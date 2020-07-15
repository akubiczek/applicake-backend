<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        if ($user->can('read all recruitments')) {
            return true;
        }

        $candidate = Candidate::findOrFail(request()->get('candidate_id'));
        if ($user->can('view', $candidate)) {
            return true;
        }

        return false;
    }
}
