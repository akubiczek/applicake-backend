<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\TenantManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\RuntimeException;

class SeedDemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:seeddemodata {tenantId}';

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
        $tenantId = $this->argument('tenantId');
        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            throw new RuntimeException('Tenant with ID = '.$tenantId.' does not exist.');
        }

        $this->tenantManager->setTenant($tenant);
        \DB::purge('tenant');

        $seeder = new \ExampleRecruitments();
        $seeder->setConnection('tenant');
        $seeder->run();

        $seeder = new \ExampleSources();
        $seeder->setConnection('tenant');
        $seeder->run();

        $seeder = new \ExampleFormFields();
        $seeder->setConnection('tenant');
        $seeder->run();

        $seeder = new \ExampleStages();
        $seeder->setConnection('tenant');
        $seeder->run();

        $seeder = new \ExamplePredefinedMessages();
        $seeder->setConnection('tenant');
        $seeder->run();

        $seeder = new \ExampleCandidates();
        $seeder->setConnection('tenant');
        $seeder->run();

        $this->info('Demo data have been seeded for tenant with subdomain \'' . $tenant->subdomain . '\'.');
    }
}
