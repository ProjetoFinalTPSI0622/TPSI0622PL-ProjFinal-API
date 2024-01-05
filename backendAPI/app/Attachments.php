<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    protected $fillable = [
        'ticket_id',
        'FileName',
        'FileType',
        'FilePath',
        'FileSize'
    ];
    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }
}
