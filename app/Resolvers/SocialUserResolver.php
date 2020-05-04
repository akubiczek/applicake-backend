<?php

namespace App\Resolvers;

use App\Models\User;
use App\Services\TenantManager;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class SocialUserResolver implements SocialUserResolverInterface
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
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        // Return the user that corresponds to provided credentials.
        // If the credentials are invalid, then return NULL.
        switch ($provider) {
            case 'google':
                return $this->googleAuth($accessToken);
        }

        return null;
    }

    protected function googleAuth(string $accessToken): ?Authenticatable
    {
        $client = new \Google_Client(['client_id' => config('auth.google_oauth_client_id')]);
        $payload = $client->verifyIdToken($accessToken);
        if ($payload) {
            $userName = $payload['email'];
            if ($this->tenantManager->loadTenantByUsername($userName)) {
                return User::where('email', $userName)->first();
            }
        }

        return null;
    }
}
