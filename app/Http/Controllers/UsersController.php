<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\InvitationService;
use App\Services\TenantManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController
{
    protected $tenantManager;

    /**
     * Create a new controller instance.
     *
     * @param TenantManager $tenantManager
     * @return void
     */
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    public function list()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function create(Request $request)
    {
    }

    public function invite(Request $request)
    {
        $invitation = InvitationService::invite($request, Auth::user(), $this->tenantManager->getTenant());
        return response()->json($invitation);
    }

    public function finishInvitation(Request $request, $token)
    {
        $user = InvitationService::finishInvitation($request, $token);

        if (!$user) {
            return response('Invitation not found', 404);
        }

        return response()->json($user);
    }


}
