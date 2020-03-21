<?php

namespace App\Utils;

use App\Models\Candidate;
use App\Mail\NewCandidateNotification;
use App\Mail\CandidateMailable;
use App\Models\Message;
use App\Models\PredefinedMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MessageService
{
    public static function sendConfirmationToCandidate($candidate)
    {
        $predefinedMessage = PredefinedMessage::where('recruitment_id', $candidate->recruitment->id)->where('stage_id', $candidate->stage_id)->first();

        if (!$predefinedMessage) {
            return false;
        }

        $message = new Message();
        $message->candidate_id = $candidate->id;
        $message->to = $candidate->email;
        $message->from = '';
        $message->subject = ContentParser::parse($predefinedMessage->subject, $candidate) . ' ' . UtilsService::hashSuffix($candidate->id);
        $message->body = ContentParser::parse($predefinedMessage->body, $candidate);
        $message->save();

        Mail::to($message->to)->queue(new CandidateMailable($message));

        //TODO: przenieść do eventu, żeby działało też dla delayed messages
        $message->sent_at = now();
        $message->save();

        return true;
    }

    public static function sendMessage(Candidate $candidate, $messageSubject, $messageBody, $delay = null, ?User $author = null)
    {
        $generalMessage = new CandidateMailable($messageSubject, $messageBody, $author);

        if (!empty($delay)) {

            $delayUntil = Carbon::parse($delay);

            Mail::to($candidate->email)->later($delayUntil, $generalMessage);

            $message = $generalMessage->toMessage();
            $message->candidate_id = $candidate->id;
            $message->scheduled_for = $delayUntil;
            $message->save();

            return false;
        }

        Mail::to($candidate->email)->queue($generalMessage);

        $message = $generalMessage->toMessage();
        $message->candidate_id = $candidate->id;
        $message->save();
    }


    public static function notifyObservers(Candidate $candidate)
    {
        $notificationEmail = $candidate->recruitment->notification_email;

        if (empty($notificationEmail)) {
            return false;
        }

        Mail::to($notificationEmail)->queue(new NewCandidateNotification($candidate));
        return true;
    }
}
