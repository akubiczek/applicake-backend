<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UsersController
{
    public function me()
    {
        return response()->json(Auth::user());
    }
}
