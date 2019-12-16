<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table = "tournaments";

    protected $fillable = [
        'owner_id',
        'name',
        'logo',
        'gender',
        'stadium',
        'address',
        'tournament_type_id',
        'number_club',
        'number_player',
        'number_group',
        'number_knockout',
        'number_round',
        'score_win',
        'score_draw',
        'score_lose',
        'register_permission',
        'register_date',
        'status',
        'slug',
        'charter',
        'introduce',
    ];

    // Tournament n-1 User
    public function user(){
        return $this->belongsTo('App\User', 'owner_id');
    }

    // Club n - n Tournament
    public function clubs(){
        return $this->belongsToMany('App\Club')->withPivot('status', 'group_id')->withTimestamps();
    }

    // Tournament 1-n Match
    public function matchs(){
        return $this->hasMany('App\Match', 'tournament_id');
    }

    // Tournament 1-n group
    public function groups(){
        return $this->hasMany('App\Group', 'tournament_id');
    }
}
