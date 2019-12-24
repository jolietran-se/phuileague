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

    public function group(){
        return $this->belongsTo('App\Group', 'group_id');
    }
    // Club n - n Tournament
    public function tournaments(){
        return $this->belongsToMany('App\Tournament')
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
                        'k_rank',
                        )
                    ->withTimestamps();
    }
}
