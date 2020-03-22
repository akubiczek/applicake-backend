<?php

namespace App\Utils\Candidates;

use App\Events\CandidateStageChanged;
use App\Http\Requests\ChangeStageRequest;
use App\Models\Candidate;
use App\Utils\MessageService;

class StageChanger
{
    public static function changeStage(ChangeStageRequest $request)
    {
        $candidate = Candidate::findOrFail($request->get('candidate_id'));
        $previousStage = $candidate->stage_id;
        $candidate->stage_id = $request->get('stage_id');
        $candidate->save();

        if ($candidate->wasChanged()) {
            if ($request->get('send_message')) {
                MessageService::sendMessage($candidate, $request);
            }
            event(new CandidateStageChanged($candidate, $previousStage, $candidate->stage_id));
        }

        return $candidate;
    }
}
