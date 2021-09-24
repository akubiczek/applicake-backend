<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Services\TenantManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class TenantDatabase implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    protected $tenant;

    protected $tenantManager;

    public function __construct(Tenant $tenant, TenantManager $tenantManager)
    {
        $this->tenant = $tenant;
        $this->tenantManager = $tenantManager;
    }

    public function handle()
    {
        $database = 'tenant_'.$this->tenant->id;
        $connection = \DB::connection('tenant');
        $createMysql = $connection->statement('CREATE DATABASE '.$database);

        if ($createMysql) {
            $this->tenantManager->setTenant($this->tenant);
            \DB::connection('tenant')->purge();
            $this->migrate();
        } else {
            $connection->statement('DROP DATABASE '.$database);
        }
    }

    private function migrate()
    {
        $migrator = app('migrator');
        $migrator->setConnection('tenant');

        if (!$migrator->repositoryExists()) {
            $migrator->getRepository()->createRepository();
        }

        $migrator->run(database_path('migrations/tenants'), []);
    }
}
