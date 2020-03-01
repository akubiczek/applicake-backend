<?php
/**
 * Created by PhpStorm.
 * User: kubik
 * Date: 18/10/2017
 * Time: 15:51
 */

namespace App\Utils;

use App\Models\Candidate;
use App\Mail\MailMessage;
use App\Mail\GeneralMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MessageService
{
    public static function sendMessage(Candidate $candidate, $messageSubject, $messageBody, $delay = null, ?User $author = null)
    {
        $generalMessage = new GeneralMessage($messageSubject, $messageBody, $author);
//throw new \Exception($generalMessage);exit;
        if (!empty($delay)) {

            $delayUntil = Carbon::parse($delay);

            //TODO odblokować
            Mail::to($candidate->email)->later($delayUntil, $generalMessage);

            $message = $generalMessage->toMessage();
            $message->candidate_id = $candidate->id;
            $message->scheduled_at = $delayUntil;
            $message->save();

            return false;
        }

        //TODO odblokować
        Mail::to($candidate->email)->queue($generalMessage);

        $message = $generalMessage->toMessage();
        $message->candidate_id = $candidate->id;
        $message->save();
    }

    public static function parseTemplate($messageTemplate, Candidate $candidate, \DateTime $appointmentDate = null)
    {
        $messageTemplate->subject = str_replace('{NAZWA_STANOWISKA}',
            $candidate->recruitment->name,
            $messageTemplate->subject);
        $messageTemplate->body = str_replace('{NAZWA_STANOWISKA}', $candidate->recruitment->name, $messageTemplate->body);

        if ($appointmentDate) {
            $messageTemplate->body = str_replace('{DATA_SPOTKANIA}', self::richDateFormat($appointmentDate), $messageTemplate->body);
            $messageTemplate->body = str_replace('{GODZINA_SPOTKANIA}', $appointmentDate->format('G:i'), $messageTemplate->body);
        }

        return $messageTemplate;
    }

    protected static function richDateFormat($date)
    {
        $prefix = '';
        $carbonDate = Carbon::instance($date)->locale('pl_PL');
        $carbonDateYesterday = $carbonDate->copy();

        if ($carbonDate->isTomorrow()) {
            $prefix = 'jutro, tj. ';
        } else if ($carbonDateYesterday->subDay(1)->isTomorrow()) {
            $prefix = 'pojutrze, tj. ';
        }

        return $prefix . $carbonDate->isoFormat('dddd, D MMMM');
    }

    public static function sendNotificationEmail(Candidate $candidate)
    {
        $notificationEmail = $candidate->recruitment->notification_email;
        if (!empty($notificationEmail)) {
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
            Mail::to($notificationEmail)->queue($generalMessage);
        }
    }
}
