<?php

namespace App\Mail;

use App\Services\UtilsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use App\MessageTemplate;
use App\Message;

class MailMessage extends Mailable
{
    use Queueable;

    /**
     * @var MessageTemplate
     */
    public $messageTemplate;
    public $candidate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageTemplate, $candidate)
    {
        $this->messageTemplate = $messageTemplate;
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
            ->view('emails.raw_email')
            ->attach($this->getCvPath());
    }

    protected function getSubject()
    {
        $position = $this->candidate->recruitment->name;
        $candidate = $this->candidate->first_name . ' ' . $this->candidate->last_name;
        $hashSuffix = UtilsService::hashSuffix($this->candidate->id);

        return "[HR] $position - $candidate $hashSuffix";
    }

    protected function getCvPath()
    {
        return storage_path('app/' . $this->candidate->path_to_cv);
    }

    protected function getViewParams()
    {
        return [
            'position' => $this->candidate->recruitment->name,
            'candidateId' => $this->candidate->id,
        ];
    }
}
