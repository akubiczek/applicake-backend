<?php

namespace App\Http\Controllers;

use App\Http\Requests\PredefinedMessageUpdateRequest;
use App\Models\Candidate;
use App\Models\PredefinedMessage;
use App\Models\StageMessageTemplate;
use App\Services\PredefinedMessageService;
use App\Utils\MessageService;
use Illuminate\Http\Request;

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

    public function get(Request $request)
    {
        //TODO: ta metoda jest czasowo wyłączona
        $candidate_id = $request->get('candidate_id');
        $stageId = $request->get('stage_id');

        $candidate = Candidate::find($candidate_id);
        $appointmentDateString = $request->get('appointment_date');
        $appointmentDate = new \DateTime($appointmentDateString);

        $template = PredefinedMessage::where('recruitment_id', $candidate->recruitment->id)->where('stage_id', $stageId)->first();
        if (empty($template)) {
            $template = StageMessageTemplate::where('stage_id', $stageId)->first();
        }

        if ($template) {
            $parsedMessage = MessageService::parseContent($template, $candidate, $appointmentDate);
            return response()->json($parsedMessage);
        }

        return response()->json(null, 404);
    }
}
