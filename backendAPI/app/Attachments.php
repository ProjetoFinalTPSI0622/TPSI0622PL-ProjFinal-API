<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    protected $fillable = [
        'ticket_id',
        'FieldName',
        'FileType',
        'FilePath'
    ];
    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }
}
