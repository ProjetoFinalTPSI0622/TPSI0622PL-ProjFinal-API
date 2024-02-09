<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'comment_type',
        'comment_body'
    ];

    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commentType()
    {
        return $this->belongsTo(CommentTypes::class, 'comment_type');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachments::class, 'attachment_comment');
    }

}
