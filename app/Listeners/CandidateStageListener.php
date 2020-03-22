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

    }
}
