<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TenantManager;
use App\Models\Tenant;
use Symfony\Component\Console\Exception\RuntimeException;

class TenantMigrate extends Command
{
    protected $signature = 'tenant:migrate {tenantId?}';

    protected $description = 'Run tenant migrations for provided tenant or for all registered tenants';

    protected $tenantManager;

    protected $migrator;

    public function __construct(TenantManager $tenantManager)
    {
        parent::__construct();

        $this->tenantManager = $tenantManager;
        $this->migrator = app('migrator');
    }

    public function handle()
    {
        $tenantId = $this->argument('tenantId');

        if ($tenantId) {
            $tenant = Tenant::find($tenantId);
            if (!$tenant) {
                throw new RuntimeException('Tenant with ID = ' . $tenantId . ' does not exist.');
            }

            $this->tenantManager->setTenant($tenant);
            \DB::purge('tenant');
            $this->migrate();

            return;
        }

        if (!$tenantId && $this->confirm('Do you wish to run migration for ALL tenants?')) {

            $tenants = Tenant::all();

            foreach ($tenants as $tenant) {
                $this->tenantManager->setTenant($tenant);
                \DB::purge('tenant');
                $this->migrate();
            }

            return;
        }

    }

    private function migrate()
    {
        $this->prepareDatabase();
        $this->migrator->run(database_path('migrations/tenants'), []);
    }

    protected function prepareDatabase()
    {
        $this->migrator->setConnection('tenant');

        if (!$this->migrator->repositoryExists()) {
            $this->call('migrate:install');
        }
    }
}
