<?php

namespace App\Providers;

use App\Http\Middleware\AppendTenantURL;
use App\Http\Middleware\IdentifyTenantByUsername;
use App\Http\Middleware\TranslateOAuthException;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes(null, ['middleware' => [IdentifyTenantByUsername::class, AppendTenantURL::class, TranslateOAuthException::class]]);
    }
}
