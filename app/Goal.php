<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $table = 'goals';

    protected $fillable = [
        'match_id',
        'player_id',
        'goal_time',
        'isowngoal',
    ];

    // Goal n-1 Player
    public function player(){
        return $this->belongsTo('App\Player', 'player_id');
    }

}
