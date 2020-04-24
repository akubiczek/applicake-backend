<?php


namespace App\Http\Middleware;

use App\Services\TenantManager;
use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AppendTenantURL
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
        $response = $next($request);
        $content = json_decode($response->content(), true);

        //if this is an oauth request then append API dedicated tenant URL
        if (!empty($content['access_token'])) {
            //TODO nie podoba mi się, że tutaj znowu ładujemy tenanta, choć załadowaliśmy go już we wcześniejszym middleware: IdentifyTenantByUsername
            if ($this->tenantManager->loadTenantByUsername($request->get('username'))) {
                $content['api_url'] = url($this->tenantManager->getTenant()->subdomain);
                $response->setContent($content);
            } else {
                throw new NotFoundHttpException('Tenant not found');
            }
        }

        return $response;
    }
}
