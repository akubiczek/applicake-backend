<?php

namespace App\Http\Controllers;

use App\Http\Requests\PredefinedMessageUpdateRequest;
use App\Models\Candidate;
use App\Models\PredefinedMessage;
use App\Services\PredefinedMessageService;
use App\Utils\ContentParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageTemplatesController extends Controller
{
    public function list(Request $request)
    {
        $recruitment_id = $request->get('recruitment_id');
        $messages = PredefinedMessage::where('recruitment_id', $recruitment_id)->get();
        return response()->json($messages);
    }

    public function update(PredefinedMessageUpdateRequest $request, $messageId)
    {
        $field = PredefinedMessageService::update($messageId, $request);
        return response()->json($field, 200);
    }

    public function getParsed(Request $request)
    {
        $candidateId = $request->get('candidate_id');
        $fromStageId = $request->get('from_stage_id');;
        $toStageId = $request->get('to_stage_id');;
        $candidate = Candidate::findOrFail($candidateId);
        $appointmentDateString = $request->get('appointment_date');
        $appointmentDate = new \DateTime($appointmentDateString);

        $predefinedMessage = PredefinedMessage::where('recruitment_id', $candidate->recruitment->id)->where('from_stage_id', $fromStageId)->where('to_stage_id', $toStageId)->first();

        if (empty($predefinedMessage)) {
            $predefinedMessage = PredefinedMessage::where('recruitment_id', $candidate->recruitment->id)->where('from_stage_id', null)->where('to_stage_id', $toStageId)->first();
        }

        if (empty($predefinedMessage)) {
            return response()->json(null, 404);
        }

        $predefinedMessage->body = ContentParser::parse($predefinedMessage->body, $candidate, $appointmentDate, Auth::user());
        $predefinedMessage->subject = ContentParser::parse($predefinedMessage->subject, $candidate, $appointmentDate, Auth::user());
        return response()->json($predefinedMessage);
    }
}
