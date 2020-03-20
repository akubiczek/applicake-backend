<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use App\Models\MessageTemplate;
use App\Models\Message;

class GeneralMessage extends Mailable
{
    use Queueable;

    public $messageSubject, $messageBody;

    protected $authorEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageSubject, $messageBody, ?User $fromUser = null)
    {
        $this->messageSubject = $messageSubject;
        $this->messageBody = $messageBody;
        $this->authorEmail = data_get($fromUser, 'email');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->replyTo(config('mail.from.address'), config('mail.from.name'));

        if ($this->authorEmail) {
            $this->replyTo($this->authorEmail);
            $this->cc($this->authorEmail);
        }

        return $this->subject($this->messageSubject)->text('emails.general_message');
    }

    /**
     * Converts GeneralMessage to Message Model for storing in database
     *
     * @return Message
     */
    public function toMessage()
    {
        $message = new Message;
        $message->type = Message::TYPE_EMAIL;
        $message->subject = $this->messageSubject;
        $message->body = View::make('emails.general_message', ['messageSubject' => $this->messageSubject, 'messageBody' => $this->messageBody])->render();
        return $message;
    }
}
