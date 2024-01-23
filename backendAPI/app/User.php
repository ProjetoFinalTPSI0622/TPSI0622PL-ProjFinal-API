<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'internalcode',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Roles::class);
    }

    public function hasRole($role)
    {
        return (bool)$this->roles()->where('role', $role)->first();
    }

    public function savedResponses()
    {
        return $this->hasMany(UserSavedResponses::class);
    }

    public function createdTicket()
    {
        return $this->hasMany(Tickets::class, 'createdby');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

}
