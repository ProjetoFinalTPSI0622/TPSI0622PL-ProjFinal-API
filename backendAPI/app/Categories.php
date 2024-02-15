<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'name'
    ];
    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'category');
    }
}
