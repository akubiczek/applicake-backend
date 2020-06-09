<?php


class ExampleRecruitments extends \App\Services\TenantSeeder
{
    const JSON_PATH = './database/seeds/recruitments.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recruitments = json_decode(file_get_contents(self::JSON_PATH), true);
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $id = 1;

        foreach ($recruitments as $recruitment)
        {
            DB::connection($this->connection)->table('recruitments')->insert([
                'id' => $id,
                'name' => $recruitment['name'],
                'notification_email' => $recruitment['notification_email'],
                'created_at' => $now,
                'updated_at' => $now,
                'is_draft' => false,
            ]);

            $id++;
        }
    }
}
