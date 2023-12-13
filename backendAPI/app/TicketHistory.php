<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
