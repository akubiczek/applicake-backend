<?php

namespace App\Listeners;

use App\Events\CandidateDeleted;
use App\Utils\MessageService;

class CandidateDeleteListener
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
     * @param CandidateDeleted $event
     *
     * @return void
     */
    public function handle(CandidateDeleted $event)
    {
        if ($event->emailAddress) {
            MessageService::notifyDeletedCandidate($event->candidate, $event->emailAddress);
        }
    }
}
