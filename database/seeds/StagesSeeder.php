<?php

/**
 * This seeder is used in production code to seeds new recruitments. Be careful!
 */
class StagesSeeder extends \App\Services\TenantSeeder
{
    const JSON_PATH = '/database/seeds/stages.json';

    /**
     * Run the database seeds.
     *
     * @param \App\Models\Recruitment $recruitment
     * @return void
     */
    public function run(\App\Models\Recruitment $recruitment)
    {
        $stages = json_decode(file_get_contents(base_path() . self::JSON_PATH), true);
        $now = \Carbon\Carbon::now()->toDateTimeString();

        foreach ($stages as $stage) {
            DB::connection($this->connection)->table('stages')->insert([
                'id' => $stage['id'],
                'name' => $stage['name'],
                'action_name' => $stage['action_name'],
                'has_appointment' => $stage['has_appointment'],
                'recruitment_id' => $recruitment->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
