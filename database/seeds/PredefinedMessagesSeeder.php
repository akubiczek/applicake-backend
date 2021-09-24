<?php

class PredefinedMessagesSeeder extends \App\Services\TenantSeeder
{
    const JSON_PATH = '/database/seeds/predefined_messages.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\App\Models\Recruitment $recruitment = null)
    {
        $messages = json_decode(file_get_contents(base_path().self::JSON_PATH), true);
        $now = \Carbon\Carbon::now()->toDateTimeString();

        foreach ($messages as $message) {
            $from_stage_id = null;
            $to_stage_id = null;

            if ($message['from_stage'] !== null) {
                $from_stage_id = DB::connection($this->connection)->table('stages')
                    ->where('recruitment_id', $recruitment->id)
                    ->where('order', $message['from_stage'])->select('id')->value('id');
            }

            if ($message['to_stage'] !== null) {
                $to_stage_id = DB::connection($this->connection)->table('stages')
                    ->where('recruitment_id', $recruitment->id)
                    ->where('order', $message['to_stage'])->select('id')->value('id');
            }

            DB::connection($this->connection)->table('predefined_messages')->insert([
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
}
