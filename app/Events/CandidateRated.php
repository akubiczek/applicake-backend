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

class CandidateRated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Candidate
     */
    public $candidate;

    public $previousRate, $newRate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Candidate $candidate, $previousRate, $newRate)
    {
        $this->candidate = $candidate;
        $this->previousRate = $previousRate;
        $this->newRate = $newRate;
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
