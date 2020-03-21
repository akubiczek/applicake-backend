<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use App\Models\PredefinedMessage;
use App\Models\Message;

class CandidateMailable extends Mailable
{
    use Queueable;

    /**
     * @var Message
     */
    public $messageToSend; //the name cannot be just $message bacause it interferes with sth

    /**
     * Create a new message instance.
     *
     * @param Message $messageToSend
     */
    public function __construct(Message $messageToSend)
    {
        $this->messageToSend = $messageToSend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (!empty($this->messageToSend->reply_to)) {
            $this->replyTo($this->messageToSend->reply_to);
        }

        if (!empty($this->messageToSend->cc)) {
            $this->cc($this->messageToSend->cc);
        }

        return $this->subject($this->messageToSend->subject)->view('emails.candidate');
    }
}
