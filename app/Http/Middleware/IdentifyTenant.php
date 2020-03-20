<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\TenantManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IdentifyTenant
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
        $host = $request->getHost();
        $pos = strpos($host, config('app.tenant_domain'));

        if ($pos !== false && $this->tenantManager->loadTenant(substr($host, 0, $pos - 1))) {
            return $next($request);
        }

        throw new NotFoundHttpException('Tenant not found');
    }
}
