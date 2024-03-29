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
        'location',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdby');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assignedto');
    }

    // Outros relacionamentos...

    // Exemplo de relacionamento com os modelos Status, Priority e Category (muitos para muitos)
    public function status()
    {
        return $this->belongsTo(Statuses::class, 'status');
    }

    public function priority()
    {
        return $this->belongsTo(Priorities::class, 'priority');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'ticket_id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachments::class, 'attachment_ticket');
    }
}
