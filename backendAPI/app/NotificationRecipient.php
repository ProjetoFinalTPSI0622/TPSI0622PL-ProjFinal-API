<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationRecipient extends Model
{
    protected $fillable = [
        'notification_id',
        'recipient_id',
    ];

    public function notification()
    {
        return $this->belongsTo('App\Notification');
    }

    public function recipient()
    {
        return $this->belongsTo('App\User');
    }

}
