<?php

namespace App\Utils\Candidates;

use App\Events\CandidateMoved;
use App\Events\CandidateRated;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;

class CandidateUpdater
{
    public static function updateCandidate($candidateId, $request)
    {
        $candidate = Candidate::findOrFail($candidateId);

        if (isset($request->recruitment_id)) {
            event(new CandidateMoved($candidate, $candidate->recruitment_id, $request->recruitment_id, Auth::user()->id));
            $candidate->recruitment_id = $request->recruitment_id;
        }

        if (isset($request->rate)) {
            event(new CandidateRated($candidate, $candidate->rate, $request->rate, Auth::user()->id));
            $candidate->rate = $request->rate;
        }

        $candidate->save();

        return $candidate;
    }
}
