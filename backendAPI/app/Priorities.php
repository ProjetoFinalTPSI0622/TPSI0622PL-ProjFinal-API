<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priorities extends Model
{
    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'priority');
    }
}
