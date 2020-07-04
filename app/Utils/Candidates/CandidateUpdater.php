<?php

namespace App\Utils\Candidates;

use App\Events\CandidateMoved;
use App\Events\CandidateRated;
use App\Models\Candidate;
use App\Utils\StageHelper;
use Illuminate\Support\Facades\Auth;

class CandidateUpdater
{
    public static function updateCandidate($candidateId, $request)
    {
        $candidate = Candidate::findOrFail($candidateId);

        if (isset($request->recruitment_id)) {
            return self::moveCandidate($candidate, $request->recruitment_id);
        }

        if (isset($request->rate)) {
            event(new CandidateRated($candidate, $candidate->rate, $request->rate, Auth::user()->id));
            $candidate->rate = $request->rate;
            $candidate->save();
        }

        return $candidate;
    }

    public static function moveCandidate($candidate, $recruitmentId)
    {
        $prevRecruitmentId = $candidate->recruitment_id;
        $candidate->recruitment_id = $recruitmentId;
        $candidate->stage_id = StageHelper::getFirstStage($recruitmentId)->id;
        $candidate->save();

        event(new CandidateMoved($candidate, $prevRecruitmentId, $recruitmentId, Auth::user()->id));

        return $candidate;
    }
}
