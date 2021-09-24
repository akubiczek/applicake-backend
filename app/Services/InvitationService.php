<?php

namespace App\Services;

use App\Mail\UserInvitation;
use App\Models\User;
use App\TenantUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InvitationService
{
    const KEY_MAXLENGTH = 8;

    public static function invite(Request $request, $user, $tenant)
    {
        $invitation = new \App\Models\UserInvitation();

        $invitation->inviter_id = $user->id;
        $invitation->email = $request->get('email');
        if ($request->get('name')) {
            $invitation->name = $request->get('name');
        }
        $invitation->token = self::generateKey();

        $user = new User();
        $user->email = $request->get('email');
        $user->pending_invitation = true;

        $tenantUser = new TenantUser();
        $tenantUser->username = $user->email;
        $tenantUser->tenant_id = $tenant->id;

        DB::transaction(function () use ($tenantUser, $user, $invitation) {
            $tenantUser->save();
            $user->save();
            $invitation->save();
        });

        if ($request->get('role')) {
            $user->assignRole($request->get('role'));
        }

        $invitation->subdomain = $tenant->subdomain;
        Mail::to($user->email)->queue(new UserInvitation($invitation));

        unset($invitation->token);

        return $invitation;
    }

    public static function finishInvitation(Request $request, $token)
    {
        $invitation = \App\Models\UserInvitation::where('token', $token)->first();

        if (!$invitation) {
            return false;
        }

        $user = User::where('email', $invitation->email)->first();
        if (!$user) {
            throw new \Exception('Invited user not found');
        }

        $user->name = $request->get('name');
        $user->password = bcrypt($request->get('password'));
        $user->pending_invitation = false;

        $invitation->token = null;

        DB::transaction(function () use ($user, $invitation) {
            $user->save();
            $invitation->save();
        });

        return $user;
    }

    private static function generateKey()
    {
        do {
            $key = strtoupper(\Str::random(self::KEY_MAXLENGTH));
            $invitations = \App\Models\UserInvitation::where('token', $key)->count();
        } while ($invitations > 0);

        return $key;
    }
}
