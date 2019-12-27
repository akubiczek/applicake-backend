<?php

namespace App\Repositories;

use App\Candidate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CandidatesRepository
{
    public static function getOtherApplications(Candidate $candidate)
    {
        return Candidate::where('id', '!=', $candidate->id)
            ->where(function ($query) use ($candidate) {
                $query->where('email', '=', $candidate->email)
                    ->orWhere('email', '=', sha1($candidate->email))
                    ->orWhere('phone_number', '=', $candidate->phone_number)
                    ->orWhere('phone_number', '=', sha1($candidate->phone_number));
            })
            ->with('recruitment')
            ->get();
    }
}
