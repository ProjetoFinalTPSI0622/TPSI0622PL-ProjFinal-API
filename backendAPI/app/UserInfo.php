<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'normalized_name',
        'class',
        'nif',
        'birthday_date',
        'gender_id',
        'profile_picture_path',
        'phone_number',
        'address',
        'postal_code',
        'city',
        'district',
        'country_id'
    ];

    public function Genders()
    {
        return $this->belongsTo(Genders::class);
    }

    public function Countries()
    {
        return $this->belongsTo(Countries::class);
    }

    public function Users()
    {
        return $this->belongsTo(User::class);
    }

}
