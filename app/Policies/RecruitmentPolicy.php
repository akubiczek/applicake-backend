<?php

namespace App\Policies;

use App\Models\Recruitment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecruitmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Recruitment $recruitment)
    {
        if ($user->can('read all recruitments')) {
            return true;
        }

        if ($user->recruitments->contains($recruitment->id)) {
            return true;
        }

        return false;
    }

    public function update(User $user, Recruitment $recruitment)
    {
        if ($user->can('update any recruitment')) {
            return true;
        }

        return false;
    }

    public function close(User $user, Recruitment $recruitment)
    {
        if ($user->can('update any recruitment')) {
            return true;
        }

        return false;
    }

    public function reopen(User $user, Recruitment $recruitment)
    {
        if ($user->can('update any recruitment')) {
            return true;
        }

        return false;
    }

    public function create(User $user)
    {
        if ($user->can('create recruitments')) {
            return true;
        }

        return false;
    }

    public function duplicate(User $user, Recruitment $recruitment)
    {
        if ($user->can('view', $recruitment) && $user->can('create recruitments')) {
            return true;
        }

        return false;
    }
}
