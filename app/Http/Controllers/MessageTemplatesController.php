<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\CandidatesListRequest;
use App\Mail\ForwardCv;
use App\MessageTemplate;
use App\Repositories\RecruitmentsRepository;
use App\Services\CandidateDeleter;
use App\StageMessageTemplate;
use App\Utils\MessagesService;

class MessageTemplatesController extends Controller
{
    public function get(CandidatesListRequest $request)
    {
        $candidate_id = $request->get('candidate_id');
        $stageId = $request->get('stage_id');

        $candidate = Candidate::find($candidate_id);
        $appointmentDateString = $request->get('appointment_date');
        $appointmentDate = new \DateTime($appointmentDateString);

        $template = MessageTemplate::where('recruitment_id', $candidate->recruitment->id)->where('stage_id', $stageId)->first();
        if (empty($template)) {
            $template = StageMessageTemplate::where('stage_id', $stageId)->first();
        }

        $parsedMessage = MessagesService::parseTemplate($template, $candidate, $appointmentDate);
        return response()->json($parsedMessage);
    }
}
