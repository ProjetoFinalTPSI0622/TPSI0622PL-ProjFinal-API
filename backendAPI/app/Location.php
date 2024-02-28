<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name'
    ];

    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'location');
    }
}
