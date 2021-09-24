<?php

namespace App\Listeners;

use App\Events\CandidateStageChanged;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     *
     * @return void
     */
    public function handle(CandidateStageChanged $event)
    {
    }
}
