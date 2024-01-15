<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tickets extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'createdby',
        'assignedto',
        'title',
        'description',
        'status',
        'priority',
        'category',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdby');
    }

    public function assignedToUser()
    {
        return $this->belongsTo(User::class, 'assignedto');
    }

    // Outros relacionamentos...

    // Exemplo de relacionamento com os modelos Status, Priority e Category (muitos para muitos)
    public function status()
    {
        return $this->belongsTo(Statuses::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priorities::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
