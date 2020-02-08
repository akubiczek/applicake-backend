<?php

use Illuminate\Database\Seeder;

class ExampleRecruitments extends Seeder
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
            DB::table('recruitments')->insert([
                'id' => $id,
                'name' => $recruitment['name'],
                'notification_email' => $recruitment['notification_email'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('sources')->insert([
                'name' => 'KISSdigital.com',
                'recruitment_id' => $id,
                'key' => 'XXXYYZ'.$id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $id++;
        }

    }
}
