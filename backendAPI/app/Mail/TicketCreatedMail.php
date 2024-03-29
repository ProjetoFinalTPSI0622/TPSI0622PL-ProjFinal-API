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
        // change from to something like CESAEDESK <email>
        return $this->markdown('emails.ticket-created')
                    ->subject('Ticket # ' . $this->ticket->id . ' - ' . $this->ticket->title)
                    ->with([
                        'ticket' => $this->ticket,
                    ]);
    }
}
