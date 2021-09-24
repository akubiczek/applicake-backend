<?php

namespace App\Listeners;

use App\Events\CandidateApplied;
use App\Utils\MessageService;

class CandidateApplyListener
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
     * @param object $event
     *
     * @return void
     */
    public function handle(CandidateApplied $event)
    {
        MessageService::sendConfirmationToCandidate($event->candidate);
        MessageService::notifyObservers($event->candidate);
    }
}
