<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = ['role'];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('User');
    }
}