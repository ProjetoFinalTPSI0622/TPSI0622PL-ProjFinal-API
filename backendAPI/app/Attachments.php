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
    public function tickets()
    {
        return $this->belongsToMany(Tickets::class, 'attachment_ticket');
    }

    public function comments()
    {
        return $this->belongsToMany(Comments::class, 'attachment_comment');
    }
}
