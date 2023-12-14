<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }
}
