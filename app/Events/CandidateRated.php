<?php

namespace App\Events;

use App\Models\Candidate;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CandidateRated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var Candidate
     */
    public $candidate;

    public $userId;
    public $previousRate;
    public $newRate;

    /**
     * Create a new event instance.
     *
     * @param Candidate $candidate
     * @param $previousRate
     * @param $newRate
     * @param $userId
     */
    public function __construct(Candidate $candidate, $previousRate, $newRate, $userId)
    {
        $this->candidate = $candidate;
        $this->previousRate = $previousRate;
        $this->newRate = $newRate;
        $this->userId = $userId;
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
