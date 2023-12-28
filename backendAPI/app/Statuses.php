<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    protected $fillable = [
        'status_name'
    ];
    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'status');
    }
}
