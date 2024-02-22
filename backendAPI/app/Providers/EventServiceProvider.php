<?php

namespace App\Providers;

use App\Events\NewUserEvent;
use App\Events\NotificationEvent;
use App\Events\PasswordResetEvent;
use App\Events\TicketAssignedEvent;
use App\Events\TicketCreatedEvent;
use App\Events\TicketStatusChangedEvent;
use App\Events\TicketUpdateEvent;
use App\Listeners\NewUserListener;
use App\Listeners\NotificationEventListener;
use App\Listeners\NotifyPasswordResetListener;
use App\Listeners\PasswordResetEventListener;
use App\Listeners\TicketAssignedEventListener;
use App\Listeners\TicketCreatedEventListener;
use App\Listeners\TicketStatusChangedListener;
use App\Mail\NotifyPasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\NewTicketCreated;
use App\Listeners\SendTicketNotification;
use App\Listeners\TicketUpdateListener;
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
        TicketCreatedEvent::class => [
            TicketCreatedEventListener::class,
        ],

        TicketStatusChangedEvent::class => [
            TicketStatusChangedListener::class,
        ],

        TicketAssignedEvent::class => [
            TicketAssignedEventListener::class,
        ],

        PasswordResetEvent::class => [
            PasswordResetEventListener::class,
        ],

        NotifyPasswordReset::class => [
            NotifyPasswordResetListener::class,
        ],

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
