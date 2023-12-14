<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSettings extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'notification_preference'
    ];

    public function Users()
    {
        return $this->belongsTo(User::class);
    }
}
