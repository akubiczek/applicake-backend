<?php

namespace App\Events;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CandidateStageChanged
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var Candidate
     */
    public $candidate;

    /**
     * @var User
     */
    public $user;

    public $previousStage;
    public $newStage;

    /**
     * Create a new event instance.
     *
     * @param Candidate $candidate
     * @param $previousStage
     * @param $newStage
     */
    public function __construct(Candidate $candidate, $previousStage, $newStage)
    {
        $this->candidate = $candidate;
        $this->previousStage = $previousStage;
        $this->newStage = $newStage;
        $this->user = Auth::user();
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
