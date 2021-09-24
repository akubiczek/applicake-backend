<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class CandidateMailable extends Mailable
{
    use Queueable;

    /**
     * @var Message
     */
    private $messageToSend; //the name cannot be just $message bacause it interferes with sth

    /**
     * Using in event listener.
     *
     * @var int
     */
    public $messageId;

    /**
     * We need Tenant to use in MessageSentListener.
     *
     * @var string
     */
    public $tenantIdentifier;

    /**
     * Create a new message instance.
     *
     * @param Message $messageToSend
     */
    public function __construct(Message $messageToSend)
    {
        $this->messageToSend = $messageToSend;
        $this->messageId = $messageToSend->id;

        $tenantManager = resolve('App\Services\TenantManager');
        $this->tenantIdentifier = $tenantManager->getTenant()->subdomain;
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

        return $this->subject($this->messageToSend->subject)->view('emails.candidate', ['messageToSend' => $this->messageToSend]);
    }
}
