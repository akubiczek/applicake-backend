<?php


class ExampleStages extends \App\Services\TenantSeeder
{
    const JSON_PATH = './database/seeds/stages.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = json_decode(file_get_contents(self::JSON_PATH), true);
        $now = \Carbon\Carbon::now()->toDateTimeString();

        $recruitments = \App\Models\Recruitment::get();

        foreach ($recruitments as $recruitment) {
            foreach ($stages as $stage) {
                DB::connection($this->connection)->table('stages')->insert([
                    'id' => $stage['id'],
                    'name' => $stage['name'],
                    'recruitment_id' => $recruitment->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            break; //TODO na razie nie obsługujemy osobnych konfiguracji etapów per rekrutacja
        }
    }
}
