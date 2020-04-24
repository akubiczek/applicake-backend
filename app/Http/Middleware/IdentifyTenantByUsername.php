<?php

namespace App\Http\Middleware;

use App\Services\TenantManager;
use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IdentifyTenantByUsername
{
    /**
     * @var App\Services\TenantManager
     */
    protected $tenantManager;

    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->tenantManager->loadTenantByUsername($request->get('username'))) {
            return $next($request);
        }

        throw new NotFoundHttpException('Tenant not found');
    }
}
