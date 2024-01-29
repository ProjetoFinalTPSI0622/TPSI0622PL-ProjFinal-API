<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notification_data',
    ];

    public function recipients()
    {
        return $this->hasMany('App\NotificationRecipient');
    }
}
