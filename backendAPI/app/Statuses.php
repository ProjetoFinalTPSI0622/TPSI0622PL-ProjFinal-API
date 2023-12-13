<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'status');
    }
}
