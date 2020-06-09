<?php

class ExampleCandidates extends \App\Services\TenantSeeder
{
    const JSON_PATH = './database/seeds/candidates.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $candidates = json_decode(file_get_contents(self::JSON_PATH), true);
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $counter = 0;
        $recruitments = \App\Models\Recruitment::pluck('id')->toArray();
        $sources = [];
        $stages = [];

        foreach ($recruitments as $id) {
            $sources[$id] = \App\Models\Source::where('recruitment_id', $id)->pluck('id')->toArray();
            $stages[$id] = \App\Models\Stage::where('recruitment_id', $id)->pluck('id')->toArray();
        }

        foreach ($candidates['results'] as $candidate) {
            $recruitment_id = $counter < 20 ? $recruitments[0] : $recruitments[1];

            $seen = false;
            $stageIndex = random_int(0, count($stages[$recruitment_id]) - 1);
            $stage_id = $stages[$recruitment_id][$stageIndex];

            if ($stageIndex > 0) {
                $seen = true;
            }

            $rate = (random_int(0, 3) == 0 ? random_int(1, 5) : null);

            DB::connection($this->connection)->table('candidates')->insert([
                'name' => $candidate['name']['first'] . ' ' . $candidate['name']['last'],
                'email' => $candidate['email'],
                'phone_number' => $candidate['cell'],
                'future_agreement' => random_int(0, 1),
                'recruitment_id' => $recruitment_id,
                'stage_id' => $stage_id,
                'rate' => $seen ? $rate : null,
                'source_id' => $sources[$recruitment_id][0],
                'seen_at' => $seen ? $now : null,
                'created_at' => $now,
                'updated_at' => $now,
                'path_to_cv' => '',
            ]);

            $counter++;
        }
    }
}
