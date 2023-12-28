<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priorities extends Model
{
    protected $fillable = [
        'priority_name'
    ];
    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'priority');
    }
}
