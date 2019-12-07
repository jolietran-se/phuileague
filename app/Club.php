<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'clubs';

    protected $fillable = [
        'name',
        'owner_id',
        'logo',
        'uniform',
        'gender',
        'ages',
        'phone',
        'email',
        'club_type',
        'number_player',
        'slug',
        'description',
    ];

    // Club 1-n Player
    public function players(){
        return $this->hasMany('App\Player');
    }

    // Club n - 1 User
    public function user(){
        return $this->belongsTo('App\User', 'owner_id');
    }

    // Club n - n Tournament
    public function tournaments(){
        return $this->belongsToMany('App\Tournament')->withPivot('status')->withTimestamps();
    }
}
