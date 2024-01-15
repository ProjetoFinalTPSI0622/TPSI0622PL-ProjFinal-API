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

    public int $ticket_id;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        //this->ticket_id = $id;
    }

    /**
     * Handle the event.
     *
     * @param  NewTicketCreated  $event
     * @return void
     */
    public function handle(NewTicketCreated $event)
    {

        // Aqui, você pode definir a lógica para determinar os destinatários da notificação

        // Por exemplo, você pode querer enviar para o usuário designado ou um grupo de usuários
        $ticket = Tickets::with('createdBy')->find($event->ticket_id);
        $user = $ticket->createdBy;
        //dd($ticket);
        //dd($user);
           // \Log::alert(Notification::send($user, new TicketCreated($event->ticket_id)));
        $user->notify(new ticketCreated($event->ticket_id));
    }
}
