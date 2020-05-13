<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordTokenRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Services\TenantManager;
use Illuminate\Support\Str;

class PasswordsController extends Controller
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

    public function token(PasswordTokenRequest $request)
    {
        if ($this->tenantManager->loadTenantByUsername($request->email)) {

            $user = User::where('email', $request->email)->first();

            if ($user) {
                $passwordReset = PasswordReset::updateOrCreate(
                    ['email' => $user->email],
                    ['email' => $user->email, 'token' => Str::random(60)]
                );

                if ($passwordReset) {
                    $user->notify(new PasswordResetRequest($passwordReset->token));
                }
            }
        }

        //always empty response regardless of actual result (for security reasons)
        return response()->json();
    }


    public function reset(\App\Http\Requests\PasswordResetRequest $request)
    {
        $passwordReset = PasswordReset::where('token', $request->get('token'))->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'This password reset token is invalid.'], 404);
        }

        if ($this->tenantManager->loadTenantByUsername($passwordReset->email)) {
            $user = User::where('email', $passwordReset->email)->first();

            if (!$user) {
                return response()->json(['message' => 'We can\'t find a user with that e-mail address.'], 404);
            }

            $user->password = bcrypt($request->get('password'));
            $user->save();
            $passwordReset->delete();

            $user->notify(new PasswordResetSuccess());
        }

        return response()->json(['message' => 'Password has been changed.']);
    }
}






