<?php

namespace App\Http\Middleware;

use Closure;

class TranslateOAuthException
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Convert oauth 400 response to 401 without any payload
        //It's required due to security reasons - we got two levels of "authentication" - the first is to check if user
        //exists in IdentifyTenantByUsername middleware - so we need IDENTICAL(!) responses here and there
        $response = $next($request);

        if ($response->status() === 400) {
            return response('', 401);
        }

        return $response;
    }
}
