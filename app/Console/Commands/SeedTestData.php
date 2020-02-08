<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seedtestdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed database with example recruitments and fake candidates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $seeder = new \ExampleRecruitments();
        $seeder->run();

        $seeder = new \ExampleCandidates();
        $seeder->run();
    }
}
