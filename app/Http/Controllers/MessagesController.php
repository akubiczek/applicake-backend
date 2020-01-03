<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Message;
use App\Recruitment;
use App\MessageTemplate;
use App\Services\UtilsService;
use App\StageMessageTemplate;
use Illuminate\Http\Request;
use App\Services\MessagesService;

class MessagesController extends Controller
{
    public function list(Request $request)
    {
        $candidateId = $request->get('candidate_id');

        if ($candidateId) {
            $messages = Message::where('candidate_id', $candidateId)->orderBy('created_at', 'ASC')->get();
        } else {
            $messages = Message::orderBy('id', 'ASC')->get();
        }

        return response()->json($messages);
    }

    public function templateParsedAjax(Request $request)
    {
        $candidate = Candidate::find($request->candidate_id);

        $hashSuffix = UtilsService::hashSuffix($request->candidate_id);

        $messageTemplate = MessageTemplate::where('recruitment_id', $candidate->recruitment_id)->where('stage_id', $request->stage_id)->first();

        if (!$messageTemplate)
        {
            $messageTemplate = StageMessageTemplate::where('stage_id', $request->stage_id)->first();
        }

        if (!$messageTemplate)
        {
            return response()->json([
                'subject' => $hashSuffix,
                'body' => ''
            ]);
        }

        MessagesService::parseTemplate($messageTemplate, $candidate);

        return response()->json([
            'subject' => "$messageTemplate->subject $hashSuffix",
            'body' => $messageTemplate->body
        ]);
    }

    public function update(Request $request, $id)
    {
        $messageTemplate = MessageTemplate::find($id);
        $messageTemplate->update($request->all());

        return 'OK';
    }
}
