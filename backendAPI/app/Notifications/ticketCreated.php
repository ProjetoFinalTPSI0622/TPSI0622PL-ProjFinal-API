<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Tickets;

class ticketCreated extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $ticket_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket_id)
    {
        $this->ticket = $ticket_id;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
   /* public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => 'New Ticket Created',
            'message' => 'A new ticket has been created: ' . $this->ticket->title // Assuming 'title' is a field in your Ticket model
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => 'New Ticket Created',
            'message' => 'A new ticket has been created: ' . $this->ticket->title // Assuming 'title' is a field in your Ticket model
        ];
    }

    /*
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A new ticket has been created.')
            ->action('View Ticket', url('/tickets/' . $this->ticket->id))
            ->line('Thank you for using our application!');
    }
    */
}
