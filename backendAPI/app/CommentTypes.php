<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentTypes extends Model
{
    public function comments()
    {
        return $this->hasMany(Comments::class, 'comment_type');
    }
}
