<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\TenantManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Exception\RuntimeException;

class ImportOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legacydata:import {tenantId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data from legacy database (the first version of HR system)';

    protected $tenantManager;

    /**
     * Create a new command instance.
     *
     * @param TenantManager $tenantManager
     */
    public function __construct(TenantManager $tenantManager)
    {
        parent::__construct();

        $this->tenantManager = $tenantManager;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tenantId = $this->argument('tenantId');
        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            throw new RuntimeException('Tenant with ID = '.$tenantId.' does not exist.');
        }

        if (!$this->confirm('Do you REALLY WANT to run import legacy data?')) {
            return;
        }

        if (!$this->confirm('It will ERASE ALL current data for ::'.$tenant->subdomain.':: tenant. Are you sure?')) {
            return;
        }

        $this->tenantManager->setTenant($tenant);
        \DB::purge('tenant');

        DB::connection('tenant')->delete('DELETE FROM sources');
        DB::connection('tenant')->delete('DELETE FROM notes');
        DB::connection('tenant')->delete('DELETE FROM messages');
        DB::connection('tenant')->delete('DELETE FROM activities');
        DB::connection('tenant')->delete('DELETE FROM form_fields');
        DB::connection('tenant')->delete('DELETE FROM predefined_messages');
        DB::connection('tenant')->delete('DELETE FROM stages');
        DB::connection('tenant')->delete('DELETE FROM recruitments');
        DB::connection('tenant')->delete('DELETE FROM candidates');
        DB::connection('tenant')->delete('DELETE FROM user_invitations');
        DB::connection('tenant')->delete('DELETE FROM users');

        DB::connection()->delete('DELETE FROM tenant_users WHERE tenant_id='.$tenant->id);

        DB::connection('tenant')->statement('ALTER TABLE sources AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE notes AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE messages AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE activities AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE form_fields AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE predefined_messages AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE stages AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE recruitments AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE candidates AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE user_invitations AUTO_INCREMENT = 1;');
        DB::connection('tenant')->statement('ALTER TABLE users AUTO_INCREMENT = 1;');

        $users = DB::connection('legacy')->select('SELECT * FROM users');
        foreach ($users as $user) {
            $email = str_replace('.pl', '.com', $user->email);
            DB::connection('tenant')->insert(
                'INSERT INTO users (id, created_at, updated_at, `name`, email, `password`)
                VALUES (?, ?, ?, ?, ?, ?)',
                [
                    $user->id,
                    $user->created_at,
                    $user->updated_at,
                    $user->name,
                    $email,
                    $user->password,
                ]
            );

            DB::connection('')->insert(
                'INSERT INTO tenant_users (created_at, updated_at, `username`, tenant_id)
                VALUES (?, ?, ?, ?)',
                [
                    $user->created_at,
                    $user->updated_at,
                    $email,
                    $tenantId,
                ]
            );
        }

        $stages = json_decode('[
    {
        "order": 1,
        "name": "Nowy",
        "action_name": "Zmień etap",
        "has_appointment": false,
        "is_quick_link": false
    },
    {
        "order": 2,
        "name": "Rozmowa telefoniczna",
        "action_name": "Zmień etap",
        "has_appointment": true,
        "is_quick_link": true
    },
    {
        "order": 3,
        "name": "Spotkanie",
        "action_name": "Zmień etap",
        "has_appointment": true,
        "is_quick_link": false
    },
    {
        "order": 4,
        "name": "Złożenie oferty",
        "action_name": "Zmień etap",
        "has_appointment": false,
        "is_quick_link": false
    },
    {
        "order": 5,
        "name": "Zatrudnienie",
        "action_name": "Zmień etap",
        "has_appointment": false,
        "is_quick_link": false
    },
    {
        "order": 6,
        "name": "Odrzucenie",
        "action_name": "Odrzuć",
        "has_appointment": false,
        "is_quick_link": true
    }
]');

        $stageId = 1;
        $stageMap = [];
        $recruitments = DB::connection('legacy')->select('SELECT * FROM recruitments');
        foreach ($recruitments as $recruitment) {
            DB::connection('tenant')->insert(
                'INSERT INTO recruitments (id, created_at, updated_at, name, job_title, notification_email, is_draft, state)
                VALUES (?, ?, ?, ?, ?, ?, 0, ?)',
                [
                    $recruitment->id,
                    $recruitment->created_at,
                    $recruitment->updated_at,
                    $recruitment->name,
                    $recruitment->name,
                    $recruitment->notification_email,
                    $recruitment->state == 0 ? 0 : 2,
                ]
            );

            foreach ($stages as $stage) {
                DB::connection('tenant')->insert(
                    'INSERT INTO stages (id, created_at, updated_at, recruitment_id, name,
                has_appointment, is_quick_link, `order`, action_name)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                    [
                        $stageId,
                        new \DateTime(),
                        new \DateTime(),
                        $recruitment->id,
                        $stage->name,
                        $stage->has_appointment,
                        $stage->is_quick_link,
                        $stage->order,
                        $stage->action_name,
                    ]
                );

                $stageMap[$recruitment->id][$stage->name] = $stageId;

                $stageId++;
            }

            $fields = json_decode(file_get_contents(base_path().'/database/seeds/form_fields.json'), true);
            $now = \Carbon\Carbon::now()->toDateTimeString();

            foreach ($fields as $field) {
                DB::connection('tenant')->table('form_fields')->insert([
                    'name'           => $field['name'],
                    'label'          => $field['label'],
                    'system'         => $field['system'],
                    'type'           => $field['type'],
                    'required'       => $field['required'],
                    'order'          => $field['order'],
                    'recruitment_id' => $recruitment->id,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ]);
            }

            $messages = json_decode(file_get_contents(base_path().'/database/seeds/predefined_messages.json'), true);

            foreach ($messages as $message) {
                $from_stage_id = null;
                $to_stage_id = null;

                if ($message['from_stage'] !== null) {
                    $from_stage_id = DB::connection('tenant')->table('stages')
                        ->where('recruitment_id', $recruitment->id)
                        ->where('order', $message['from_stage'])->select('id')->value('id');
                }

                if ($message['to_stage'] !== null) {
                    $to_stage_id = DB::connection('tenant')->table('stages')
                        ->where('recruitment_id', $recruitment->id)
                        ->where('order', $message['to_stage'])->select('id')->value('id');
                }

                DB::connection('tenant')->table('predefined_messages')->insert([
                    'subject'        => $message['subject'],
                    'body'           => $message['body'],
                    'trigger'        => $message['trigger'],
                    'from_stage_id'  => $from_stage_id,
                    'to_stage_id'    => $to_stage_id,
                    'recruitment_id' => $recruitment->id,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ]);
            }
        }

        $sources = DB::connection('legacy')->select('SELECT * FROM sources');
        foreach ($sources as $source) {
            DB::connection('tenant')->insert(
                'INSERT INTO sources (id, created_at, updated_at, `name`, recruitment_id, `key`)
                VALUES (?, ?, ?, ?, ?, ?)',
                [
                    $source->id,
                    $source->created_at,
                    $source->updated_at,
                    $source->name,
                    $source->recruitment_id,
                    $source->key,
                ]
            );
        }

        $candidates = DB::connection('legacy')->select('SELECT * FROM candidates');
        foreach ($candidates as $candidate) {
            $customFields = '[{"id": 0, "label": "Informacje dodatkowe", "value": '.json_encode($candidate->additional_info).'}]';
            $seenAt = $candidate->stage_id != 1 ? $candidate->created_at : null;

            $pathToCV = 'kissdigital/'.$candidate->path_to_cv;

            $stageId = 0;

            switch ($candidate->stage_id) {
                case 1:
                case 2:
                    $stageId = $stageMap[$candidate->recruitment_id]['Nowy'];
                    break;
                case 3:
                    //rozmowa tel
                    $stageId = $stageMap[$candidate->recruitment_id]['Rozmowa telefoniczna'];
                    break;
                case 4:
                    //spotkanie
                    $stageId = $stageMap[$candidate->recruitment_id]['Spotkanie'];
                    break;
                case 5:
                case 6:
                case 7:
                case 10:
                    //odrzucenie
                    $stageId = $stageMap[$candidate->recruitment_id]['Odrzucenie'];
                    break;
                case 8:
                    //Złożenie oferty
                    $stageId = $stageMap[$candidate->recruitment_id]['Złożenie oferty'];
                    break;
                case 9:
                    //Zatrudnienie
                    $stageId = $stageMap[$candidate->recruitment_id]['Zatrudnienie'];
                    break;
            }

            $photoPath = str_replace('.pdf', '_avatar.jpg', $candidate->path_to_cv);
            $photoExtraction = \Carbon\Carbon::now()->toDateTimeString();

            if (Storage::disk('s3')->missing($photoPath)) {
                $photoPath = null;
                $photoExtraction = null;
            }

            DB::connection('tenant')->insert(
                'INSERT INTO candidates (id, created_at, updated_at, `name`, email,
                `phone_number`, future_agreement, path_to_cv, source_id, recruitment_id, seen_at, stage_id, rate, custom_fields, photo_path, photo_extraction)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $candidate->id,
                    $candidate->created_at,
                    $candidate->updated_at,
                    $candidate->first_name.' '.$candidate->last_name,
                    $candidate->email,
                    $candidate->phone_number,
                    $candidate->future_agreement,
                    $pathToCV,
                    $candidate->source_id,
                    $candidate->recruitment_id,
                    $seenAt,
                    $stageId,
                    $candidate->rate,
                    $customFields,
                    $photoPath,
                    $photoExtraction,
                ]
            );
        }

        $notes = DB::connection('legacy')->select('SELECT * FROM notes');
        foreach ($notes as $note) {
            DB::connection('tenant')->insert(
                'INSERT INTO notes (id, created_at, updated_at, `body`, candidate_id, `user_id`)
                VALUES (?, ?, ?, ?, ?, ?)',
                [
                    $note->id,
                    $note->created_at,
                    $note->updated_at,
                    $note->body,
                    $note->candidate_id,
                    $note->user_id ? $note->user_id : 2,
                ]
            );
        }
        foreach ($candidates as $candidate) {
            if ($candidate->stage_id == 10) {
                DB::connection('tenant')->insert(
                    'INSERT INTO notes (created_at, updated_at, `body`, candidate_id, `user_id`)
                VALUES (?, ?, ?, ?, ?)',
                    [
                        new \DateTime(),
                        new \DateTime(),
                        'Kandydat zrezygnował w trakcie rekrutacji',
                        $candidate->id,
                        2,
                    ]
                );
            }
        }

        $messages = DB::connection('legacy')->select('SELECT * FROM messages');
        foreach ($messages as $message) {
            $candidate = DB::connection('tenant')->select('SELECT * FROM candidates WHERE `id`='.$message->candidate_id);
            DB::connection('tenant')->insert(
                'INSERT INTO messages (id, created_at, updated_at, `type`, candidate_id,
                `subject`, `body`, `scheduled_for`, `sent_at`, `to`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $message->id,
                    $message->created_at,
                    $message->updated_at,
                    $message->type,
                    $message->candidate_id,
                    $message->subject,
                    $message->body,
                    $message->scheduled_at,
                    $message->created_at,
                    $candidate[0]->email,
                ]
            );
        }

        $this->info('Legacy data have been imported for tenant with subdomain \''.$tenant->subdomain.'\'.');
    }
}
