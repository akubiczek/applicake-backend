<?php

namespace App\Events;

use App\Models\Candidate;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CandidateMoved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Candidate
     */
    public $candidate;

    public $userId;

    public $previousRecruitmentId, $newRecruitmentId;

    /**
     * Create a new event instance.
     *
     * @param Candidate $candidate
     * @param $previousRecruitmentId
     * @param $newRecruitmentId
     * @param $userId
     */
    public function __construct(Candidate $candidate, $previousRecruitmentId, $newRecruitmentId, $userId)
    {
        $this->candidate = $candidate;
        $this->previousRecruitmentId = $previousRecruitmentId;
        $this->newRecruitmentId = $newRecruitmentId;
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
