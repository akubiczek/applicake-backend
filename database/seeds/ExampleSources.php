<?php


class ExampleSources extends \App\Services\TenantSeeder
{
    const JSON_PATH = './database/seeds/sources.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sources = json_decode(file_get_contents(self::JSON_PATH), true);
//        $now = \Carbon\Carbon::now()->toDateTimeString();
        $recruitments = \App\Models\Recruitment::get();

        foreach ($recruitments as $recruitment) {
            foreach ($sources as $source) {
                \App\Utils\SourceCreator::create(['name' => $source['name'], 'recruitment_id' => $recruitment->id]);
//                DB::connection($this->connection)->table('sources')->insert([
//                    'name' => $source['name'],
//                    'recruitment_id' => $recruitment->id,
//                    'key' => \App\Utils\SourceCreator::create()
//                    'created_at' => $now,
//                    'updated_at' => $now,
//                    'is_draft' => false,
//                ]);
//
//                $id++;
            }
        }
    }
}
