<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

public $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //TODO:
        // change subject to something like Ticket ticket_id CREATED
        // change from to something like CESAEDESK <email>
        //format a better looking markdown
        return $this->markdown('emails.ticket-created')
                    ->subject('New Ticket Created - Ticket ID: ' . $this->ticket->id)
                    ->with([
                        'ticket' => $this->ticket,
                    ]);
    }
}
