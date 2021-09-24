<?php

namespace App\Mail;

use App\Message;
use App\MessageTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class ForwardCv extends Mailable
{
//    use Queueable, SerializesModels;
    use Queueable;

    /**
     * @var MessageTemplate
     */
    public $messageTemplate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageTemplate)
    {
        $this->messageTemplate = $messageTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->messageTemplate->subject)
            ->attach($this->messageTemplate->attachment)
            ->text('emails.general_message');

//        ->subject($this->getSubject())
//        ->view('emails.raw_email')
//        ->attach($this->getCvPath());
    }
}
