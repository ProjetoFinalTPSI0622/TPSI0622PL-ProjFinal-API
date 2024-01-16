<?php

namespace App\Listeners;

use App\Events\TicketUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\TicketUpdateNotification;
use App\User;
class TicketUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TicketUpdateEvent  $event
     * @return void
     */
    public function handle(TicketUpdateEvent $event)
    {
        $users = User::All();
        foreach ($users as $user) {
            if ($user->hasRole('admin'))  {
                $user->notify(new TicketUpdateNotification($event->ticket));
            }
        }
    }
}
