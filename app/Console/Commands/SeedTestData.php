<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\TenantManager;
use Illuminate\Console\Command;

class SeedTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:seedtestdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed teenant database with example recruitments and fake candidates';

    protected $tenantManager;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TenantManager $tenantManager)
    {
        parent::__construct();

        $this->tenantManager = $tenantManager;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tenantId = $this->ask('Tenant ID');
        $tenant = Tenant::find($tenantId);

        if ($tenant) {
            $this->tenantManager->setTenant($tenant);
            \DB::purge('tenant');

            $seeder = new \ExampleRecruitments();
            $seeder->setConnection('tenant');
            $seeder->run();

            $seeder = new \ExampleCandidates();
            $seeder->setConnection('tenant');
            $seeder->run();
        } else {
            $this->error('Tenant not found');
        }
    }
}
