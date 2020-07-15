<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\TenantManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\RuntimeException;

class TenantSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:seed {tenantId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed teenant with necessary data';

    protected $tenantManager;

    /**
     * Create a new command instance.
     *
     * @param TenantManager $tenantManager
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
            throw new RuntimeException('Tenant with ID = ' . $tenantId . ' does not exist.');
        }

        $this->tenantManager->setTenant($tenant);
        \DB::purge('tenant');

        $seeder = new \RolesAndPermissionsSeeder('tenant');
        $seeder->run(null);

        $this->info('Data have been seeded for tenant with subdomain \'' . $tenant->subdomain . '\'.');
    }
}
