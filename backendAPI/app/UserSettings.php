<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSettings extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'notification_preference' //TODO: enum 1,2,3,4 (none, ticket_assigns, tickets_updates+assigned, all)
    ];

    public function Users()
    {
        return $this->belongsTo(User::class);
    }
}
