<?php

namespace App\Policies;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CandidatePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Candidate $candidate)
    {
        if ($user->can('read all recruitments')) {
            return true;
        }

        if ($user->grantedRecruitments->contains($candidate->recruitment->id)) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Candidate $candidate)
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

    public function update(User $user, Candidate $candidate)
    {
        if ($user->can('update any recruitment')) {
            return true;
        }

        if ($user->grantedRecruitments->contains($candidate->recruitment->id)) {
            return true;
        }

        return false;
    }

    public function changeStage(User $user)
    {
        if ($user->can('update any recruitment')) {
            return true;
        }

        $candidate = Candidate::findOrFail(request()->get('candidate_id'));
        if ($user->grantedRecruitments->contains($candidate->recruitment->id)) {
            return true;
        }

        return false;
    }
}
