<?php

namespace App\Events;

use App\Models\Candidate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CandidateMoved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Candidate
     */
    public $candidate;

    public $previousRecruitmentId, $newRecruitmentId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Candidate $candidate, $previousRecruitmentId, $newRecruitmentId)
    {
        $this->candidate = $candidate;
        $this->previousRecruitmentId = $previousRecruitmentId;
        $this->newRecruitmentId = $newRecruitmentId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
