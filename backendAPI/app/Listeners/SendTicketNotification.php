<?php

namespace App\Listeners;

use App\Events\NewTicketCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ticketCreated;
use App\User;
use App\Tickets;

class SendTicketNotification
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  NewTicketCreated  $event
     * @return void
     */
    public function handle(NewTicketCreated $event)
    {
        //guardar notificaçao na base de dados
        //ver o user que criou o ticket e ao admin
        //enviar notificacao
        //passar o id que acabou de ser inserido na bd da notificação


        //dd($event->ticket);
        $users = User::All();
        //dd($users);
        foreach ($users as $user) {
            if ($user->hasRole('admin')) {
                $user->notify(new ticketCreated($event->ticket));
            }
        }
    }
}
