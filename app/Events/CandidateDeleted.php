<?php

namespace App\Events;

use App\Models\Candidate;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CandidateDeleted
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var Candidate
     */
    public $candidate;

    public $emailAddress;

    /**
     * Create a new event instance.
     *
     * @param Candidate $candidate
     * @param $emailAddress
     */
    public function __construct(Candidate $candidate, $emailAddress)
    {
        $this->candidate = $candidate;
        $this->emailAddress = $emailAddress;
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
