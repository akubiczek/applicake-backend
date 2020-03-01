<?php

namespace App\Listeners;

use App\Events\CandidateStageChanged;
use App\Models\MessageTemplate;
use App\Utils\MessageService;
use App\Utils\UtilsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CandidateStageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CandidateStageChanged $event
     * @return void
     */
    public function handle(CandidateStageChanged $event)
    {
        $messageTemplate = MessageTemplate::where('recruitment_id', $event->candidate->recruitment->id)->where('stage_id', $event->candidate->stage_id)->first();

        if ($messageTemplate) {
            $hashSuffix = UtilsService::hashSuffix($event->candidate->id);
            $messageTemplate->subject = "$messageTemplate->subject $hashSuffix";

            MessageService::parseTemplate($messageTemplate, $event->candidate);
            MessageService::sendMessage($event->candidate, $messageTemplate->subject, $messageTemplate->body);
        }
    }
}
