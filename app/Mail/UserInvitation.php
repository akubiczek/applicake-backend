<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class UserInvitation extends Mailable
{
    use Queueable;

    /**
     * @var \App\Models\UserInvitation
     */
    public $invitation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Models\UserInvitation $invitation)
    {
        $this->invitation = $invitation;
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
            ->view('emails.user_invitation');
    }

    protected function getSubject()
    {
        return 'Zaproszenie do systemu Applicake.to';
    }
}
