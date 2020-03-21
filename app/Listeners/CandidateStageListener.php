<?php

namespace App\Listeners;

use App\Events\CandidateStageChanged;
use App\Models\PredefinedMessage;
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

//        if ($event->request->send_message) {
//
//            $delay = null;
//
//            if ($event->request->delay_message_send) {
//                $delay = $event->request->delayed_message_date;
//            }
//
//            MessageService::sendMessage($event->candidate, $event->request->get('message_subject'), $event->request->get('message_body'), $delay, $event->request->user());
//        }
    }
}
