<?php

namespace App\Listeners;

use App\Events\CandidateMoved;
use App\Events\CandidateRated;
use App\Events\CandidateStageChanged;
use App\Models\Activity;

class CandidateEventSubscriber
{
    public function handleCandidateMoved(CandidateMoved $event)
    {
        Activity::create([
            'candidate_id' => $event->candidate->id,
            'type'         => \App\Models\Recruitment::class,
            'user_id'      => $event->userId,
            'prev_value'   => $event->previousRecruitmentId,
            'new_value'    => $event->newRecruitmentId,
        ]);
    }

    public function handleCandidateRated(CandidateRated $event)
    {
        Activity::create([
            'candidate_id' => $event->candidate->id,
            'type'         => '\Rate',
            'user_id'      => $event->userId,
            'prev_value'   => $event->previousRate,
            'new_value'    => $event->newRate,
        ]);
    }

    public function handleCandidateStageChanged(CandidateStageChanged $event)
    {
        Activity::create([
            'candidate_id' => $event->candidate->id,
            'type'         => \App\Models\Stage::class,
            'user_id'      => $event->user->id,
            'prev_value'   => $event->previousStage,
            'new_value'    => $event->newStage,
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\CandidateMoved',
            'App\Listeners\CandidateEventSubscriber@handleCandidateMoved'
        );

        $events->listen(
            'App\Events\CandidateRated',
            'App\Listeners\CandidateEventSubscriber@handleCandidateRated'
        );

        $events->listen(
            'App\Events\CandidateStageChanged',
            'App\Listeners\CandidateEventSubscriber@handleCandidateStageChanged'
        );
    }
}
