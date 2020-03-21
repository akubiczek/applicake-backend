<?php

namespace App\Events;

use App\Http\Requests\ChangeStageRequest;
use App\Models\Candidate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CandidateStageChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Candidate
     */
    public $candidate;

    /**
     * @var ChangeStageRequest
     */
    public $request;

    public $previousStage, $newStage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Candidate $candidate, $previousStage, $newStage, ?ChangeStageRequest $request = null)
    {
        $this->candidate = $candidate;
        $this->previousStage = $previousStage;
        $this->newStage = $newStage;
        $this->request = $request;
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
