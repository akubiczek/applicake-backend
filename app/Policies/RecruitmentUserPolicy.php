<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecruitmentUserPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        if ($user->can('update any recruitment')) {
            return true;
        }

        return false;
    }

    public function create(User $user)
    {
        if ($user->can('update any recruitment')) {
            return true;
        }

        return false;
    }

    public function delete(User $user)
    {
        if ($user->can('update any recruitment')) {
            return true;
        }

        return false;
    }
}
