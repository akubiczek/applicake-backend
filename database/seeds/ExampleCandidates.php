<?php

class ExampleCandidates extends \App\Services\TenantAwareSeeder
{
    const JSON_PATH = './database/demodata/candidates.json';

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

        foreach ($candidates['results'] as $candidate) {
            DB::connection($this->connection)->table('candidates')->insert([
                'name'             => $candidate['name']['first'].' '.$candidate['name']['last'],
                'email'            => $candidate['email'],
                'phone_number'     => $candidate['cell'],
                'future_agreement' => random_int(0, 1),
                'recruitment_id'   => ($counter < 20 ? 1 : 2),
                'rate'             => (random_int(0, 3) == 0 ? random_int(1, 5) : null),
                'source_id'        => random_int(1, 2),
                'created_at'       => $now,
                'updated_at'       => $now,
                'path_to_cv'       => '',
            ]);

            $counter++;
        }
    }
}
