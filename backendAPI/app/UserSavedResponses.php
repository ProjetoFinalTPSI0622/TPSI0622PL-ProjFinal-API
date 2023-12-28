<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSavedResponses extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'response_text'
    ];

    public function Users()
    {
        return $this->belongsTo(User::class);
    }


}
