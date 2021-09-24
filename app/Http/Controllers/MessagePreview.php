<?php

namespace App\Http\Controllers;

use App\Mail\CandidateMailable;
use App\Models\Message;
use App\Models\PredefinedMessage;
use App\Utils\Candidates\CandidateCreator;
use App\Utils\ContentParser;
use Carbon\Carbon;

class MessagePreview extends Controller
{
    public function render($messageId)
    {
        $predefinedMessage = PredefinedMessage::findOrFail($messageId);
        $message = new Message();
        $message->body = ContentParser::parse(
            $predefinedMessage->body,
            CandidateCreator::fakeCandidate($predefinedMessage->recruitment),
            Carbon::tomorrow()->setHour(10)->setMinute(30)->toDateTime(),
            auth('api')->user()
        );

        return new CandidateMailable($message);
    }
}
