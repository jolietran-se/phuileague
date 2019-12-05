<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'email', 
        'avatar',
        'password',
        'phone',
        'phone_code',
        // 'slug',
        'facebook_link',
        'facebook_id',
        'google_id',
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

    // User 1-n Club
    public function clubs()
    {
        return $this->hasMany('App\Club');
    }
    // User 1-n Tournament
    public function tournaments()
    {
        return $this->hasMany('App\Tournament', 'owner_id');
    }
    // User n - n Role
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
