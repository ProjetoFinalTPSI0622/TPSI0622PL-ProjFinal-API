<?php

namespace App\Providers;

use App\Events\NewUserEvent;
use App\Events\TicketUpdateEvent;
use App\Listeners\NewUserListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
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
        NewTicketCreated::class => [
            SendTicketNotification::class,
        ],
        NewUserEvent::class => [
            NewUserListener::class,
        ],
        TicketUpdateEvent::class => [
            TicketUpdateListener::class,
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
