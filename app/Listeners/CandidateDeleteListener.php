<?php

namespace App\Listeners;

use App\Events\CandidateDeleted;
use App\Utils\MessageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
     * @return void
     */
    public function handle(CandidateDeleted $event)
    {
        MessageService::notifyDeletedCandidate($event->candidate);
    }
}
