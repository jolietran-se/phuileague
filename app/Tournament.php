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
        return $this->belongsToMany('App\Club')
                    ->withPivot(
                        'status', 
                        'group_id',
                        'g_number_win',
                        'g_number_draw',
                        'g_number_lost',
                        'g_point',
                        'g_number_yellow',
                        'g_number_red',
                        'g_goal_for',
                        'g_goal_against',
                        'isnext',
                        'k_number_win',
                        'k_number_draw',
                        'k_number_lost',
                        'k_point',
                        'k_number_yellow',
                        'k_number_red',
                        'k_goal_for',
                        'k_goal_against',
                        'g_number_match',
                        'k_number_match',
                        'g_goal_diff',
                        'g_rank',
                        'k_rank'
                        )
                    ->withTimestamps();
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
