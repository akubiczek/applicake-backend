<?php


class ExamplePredefinedMessages extends \App\Services\TenantSeeder
{
    const JSON_PATH = './database/seeds/predefined_messages.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = json_decode(file_get_contents(self::JSON_PATH), true);
        $now = \Carbon\Carbon::now()->toDateTimeString();

        $recruitments = \App\Models\Recruitment::get();

        foreach ($recruitments as $recruitment) {
            foreach ($messages as $message) {
                DB::connection($this->connection)->table('predefined_messages')->insert([
                    'subject' => $message['subject'],
                    'body' => $message['body'],
                    'from_stage_id' => $message['from_stage_id'],
                    'to_stage_id' => $message['to_stage_id'],
                    'recruitment_id' => $recruitment->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
