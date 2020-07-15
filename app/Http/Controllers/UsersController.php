<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\InvitationService;
use App\Services\TenantManager;
use App\TenantUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $users = User::with('roles')->get();
        return UserResource::collection($users);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function create(Request $request)
    {
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->save();

        if ($request->get('role')) {
            $user->syncRoles($request->get('role'));
        }

        return response()->json($user, 200);
    }

    public function delete($userId)
    {
        if ($userId != Auth::user()->id) {
            $user = User::findOrFail($userId);

            $tenantUser = TenantUser::where('username', $user->email)->where('tenant_id', $this->tenantManager->getTenant()->id)->first();

            if (!$tenantUser) {
                throw new \Exception('inconsistency detected');
            }

            DB::transaction(function () use ($tenantUser, $user) {

                $user->grantedRecruitments()->detach();
                $tenantUser->delete();

                if ($user->pending_invitation) {
                    $user->forceDelete();
                } else {
                    $user->delete();
                }
            });

            return response(200);
        }

        return response('Cannot delete yourself', 403);
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
