<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genders extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function UserInfo()
    {
        return $this->hasMany(UserInfo::class);
    }
}
