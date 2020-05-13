<?php

namespace App\Listeners;

use App\Helpers\Tenant;
use App\Models\Message;
use App\Services\TenantManager;
use Illuminate\Mail\Events\MessageSent;

class MessageSentListener
{
    private $tenantManager;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    /**
     * Handle the event.
     *
     * @param MessageSent $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        if (isset($event->data['tenantIdentifier'])) {
            $this->tenantManager->loadTenant($event->data['tenantIdentifier']);

            $message = Message::findOrFail($event->data['messageId']);
            $message->sent_at = now();
            $message->save();
        }
    }
}
