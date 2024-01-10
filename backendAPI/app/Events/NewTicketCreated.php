<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Tickets;
class NewTicketCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public int $ticket_id;
    public string $message;
    public function __construct($id, $message)
    {
        $this->ticket_id = $id;
        $this->message = $message;
        //$this->dontBroadcastToCurrentUser();
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() : Channel
    {
        return new Channel('tickets');
    }

    public function broadcastAs()
    {
        return 'ticket.created';
    }

    public function broadcastWith()
    {
        //dd($this->ticket_id, $this->message);
        return [
            'ticket_id' => $this->ticket_id,
            'message' => $this->message];
    }

}
