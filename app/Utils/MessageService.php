<?php
/**
 * Created by PhpStorm.
 * User: kubik
 * Date: 18/10/2017
 * Time: 15:51
 */

namespace App\Utils;

use App\Candidate;
use App\Mail\MailMessage;
use App\Mail\GeneralMessage;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MessagesService
{
    public static function sendMessage(Candidate $candidate, $messageTemplate, $delay = null, ?User $author = null)
    {
        $generalMessage = new GeneralMessage($messageTemplate, $author);

        if(!empty($delay) && $delay['condition'] == 1){

            $delayUntil = Carbon::createFromFormat('m/d/Y H:i', $delay['date'] . ' ' . $delay['time']);

            //TODO odblokować
            //Mail::to($candidate->email)->later($delayUntil, $generalMessage);

            $message = $generalMessage->toMessage();
            $message->candidate_id = $candidate->id;
            $message->scheduled_at = $delayUntil;
            $message->save();

            return false;
        }

        //TODO odblokować
        //Mail::to($candidate->email)->queue($generalMessage);

        $message = $generalMessage->toMessage();
        $message->candidate_id = $candidate->id;
        $message->save();
    }

    public static function parseTemplate($messageTemplate, Candidate $candidate)
    {
        $messageTemplate->subject = str_replace('{NAZWA_STANOWISKA}', $candidate->recruitment->name, $messageTemplate->subject);
        $messageTemplate->body = str_replace('{NAZWA_STANOWISKA}', $candidate->recruitment->name, $messageTemplate->body);
//        $messageTemplate->body = str_replace('{DATA_SPOTKANIA}', $candidate->recruitment->name, $messageTemplate->body);
//        $messageTemplate->body = str_replace('{GODZINA_SPOTKANIA}', $candidate->recruitment->name, $messageTemplate->body);
    }



    public static function sendNotificationEmail(Candidate $candidate)
    {
        $notificationEmail = $candidate->recruitment->notification_email;
        if(!empty($notificationEmail)){
            $messageTemplate = (object)[
                'subject' => $candidate->recruitment->name,
                'body' => view('emails.newCandidate', [
                    'candidate' => $candidate,
                ])->render(),
                'type' => 0,
                'stage_id' => 1,
                'recruitment_id' => $candidate->recruitment->id,
            ];
//            $generalMessage = new MailMessage($messageTemplate);
            $generalMessage = new MailMessage($messageTemplate, $candidate);

            //TODO odblokować
            //Mail::to($notificationEmail)->queue($generalMessage);
        }
    }
}
