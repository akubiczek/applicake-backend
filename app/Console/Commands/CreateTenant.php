<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Exception\RuntimeException;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {subdomain : tenant subdomain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new tenant with new database';

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
        $subdomain = $this->argument('subdomain');

        if (!ctype_alnum($subdomain)) {
            throw new RuntimeException('Subdomain can consist of alphanum chars only.');
        }

        $num = Tenant::where('subdomain', $subdomain)->count();

        if ($num) {
            throw new RuntimeException('Tenant with subdomain \''.$subdomain.'\' already exists.');
        }

        $tenant = new Tenant();
        $tenant->subdomain = $subdomain;
        $tenant->save();

        $databaseName = 'tenant_'.$tenant->id;
        DB::connection('tenant')->statement('CREATE DATABASE '.$databaseName);

        $this->callSilent('tenant:migrate', [
            'tenantId' => $tenant->id,
        ]);

        $this->info('Created tenant with subdomain \''.$subdomain.'\' and ID '.$tenant->id.'.');
        $this->info('Database tables has been migrated.');
    }
}
