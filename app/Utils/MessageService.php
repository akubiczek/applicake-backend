<?php

namespace App\Utils;

use App\Http\Requests\ChangeStageRequest;
use App\Mail\CandidateMailable;
use App\Mail\NewCandidateNotification;
use App\Models\Candidate;
use App\Models\Message;
use App\Models\PredefinedMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageService
{
    public static function sendConfirmationToCandidate($candidate)
    {
        $predefinedMessage = PredefinedMessage::where('recruitment_id', $candidate->recruitment->id)
            ->where('trigger', 'onApply')->first();

        if (!$predefinedMessage) {
            return false;
        }

        $message = new Message();
        $message->candidate_id = $candidate->id;
        $message->to = $candidate->email;
        //$message->from = '';
        $message->subject = ContentParser::parse($predefinedMessage->subject, $candidate).' '.UtilsService::hashSuffix($candidate->id);
        $message->body = ContentParser::parse($predefinedMessage->body, $candidate);
        $message->save();

        return self::send($message);
    }

    public static function sendMessage(Candidate $candidate, ChangeStageRequest $request)
    {
        //request->user()
        $message = new Message();
        $message->candidate_id = $candidate->id;
        $message->to = $candidate->email;
//        $message->from = '';
        $message->subject = $request->get('message_subject');
        $message->body = $request->get('message_body');

        if ($request->get('delay_message_send')) {
            $delayUntil = Carbon::parse($request->get('delayed_message_date'));
            $message->scheduled_for = $delayUntil;
        }

        $message->save();

        return self::send($message);
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

    public static function notifyDeletedCandidate(Candidate $candidate, $emailAddress)
    {
        $predefinedMessage = PredefinedMessage::where('trigger', 'onDelete')->first();

        if (!$predefinedMessage) {
            return false;
        }

        $message = new Message();
        $message->candidate_id = $candidate->id;
        $message->to = $emailAddress;
        //$message->from = '';
        $message->subject = ContentParser::parse($predefinedMessage->subject, $candidate, null, Auth::user()); // . ' ' . UtilsService::hashSuffix($candidate->id);
        $message->body = ContentParser::parse($predefinedMessage->body, $candidate, null, Auth::user());
        $message->save();

        return self::send($message);
    }

    protected static function send(Message $message)
    {
        if ($message->scheduled_for) {
            Mail::to($message->to)->later($message->scheduled_for, new CandidateMailable($message));
        } else {
            Mail::to($message->to)->queue(new CandidateMailable($message));
        }

        return true;
    }
}
