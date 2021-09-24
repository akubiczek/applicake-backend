<?php

namespace App\Providers;

use App\Events\CandidateApplied;
use App\Events\CandidateDeleted;
use App\Listeners\CandidateApplyListener;
use App\Listeners\CandidateDeleteListener;
use App\Listeners\CandidateEventSubscriber;
use App\Listeners\MessageSentListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CandidateApplied::class => [
            CandidateApplyListener::class,
        ],
        //        CandidateStageChanged::class => [
        //            CandidateStageListener::class
        //        ],
        CandidateDeleted::class => [
            CandidateDeleteListener::class,
        ],
        MessageSent::class => [
            MessageSentListener::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        CandidateEventSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
