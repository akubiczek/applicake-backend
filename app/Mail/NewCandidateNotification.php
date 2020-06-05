<?php

namespace App\Mail;

use App\Models\Candidate;
use App\Utils\UtilsService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class NewCandidateNotification extends Mailable
{
    use Queueable;

    /**
     * @var Candidate
     */
    public $candidate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Candidate $candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->getSubject())
            ->view('emails.new_candidate');
        //->attach($this->getCvPath());
    }

    protected function getSubject()
    {
        $position = $this->candidate->recruitment->name;
        $candidate = $this->candidate->name;
        $hashSuffix = UtilsService::hashSuffix($this->candidate->id);

        return "[HR] $position - $candidate $hashSuffix";
    }

    protected function getCvPath()
    {
        return storage_path('app/' . $this->candidate->path_to_cv);
    }
}
