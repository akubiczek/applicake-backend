<?php

namespace App\Policies;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
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

    public function create(User $user)
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
