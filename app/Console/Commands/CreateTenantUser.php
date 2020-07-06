<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantManager;
use App\TenantUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Exception\RuntimeException;

class CreateTenantUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {tenantId} {--email=} {--name=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new user for a tenant';

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
     * @throws \Throwable
     */
    public function handle()
    {
        $tenantId = $this->argument('tenantId');
        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            throw new RuntimeException('Tenant with ID = '.$tenantId.' does not exist.');
        }

        $this->comment('Creating new user for tenant with subdomain \''.$tenant->subdomain.'\'.');

        $email = $this->option('email');
        if (!$email) {
            $email = $this->ask('User\'s email');
        }

        $num = TenantUser::where('username', $email)->count();
        if ($num) {
            throw new RuntimeException('User with email \''.$email.'\' already exists.');
        }

        $name = $this->option('name');
        if (!$name) {
            $name = $this->ask('User\'s full name');
        }

        $password = $this->option('password');
        if (!$password) {
            $password = $this->secret('User\'s password');
        }

        $tenantUser = new TenantUser();
        $tenantUser->username = $email;
        $tenantUser->tenant_id = $tenant->id;

        $this->tenantManager->setTenant($tenant);
        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = bcrypt($password);

        $user->assignRole('super-admin');

        DB::transaction(function () use ($tenantUser, $user) {
            $tenantUser->save();
            $user->save();
        });

        $this->comment('Created user with username \'' . $user->email . '\'.');
    }
}
