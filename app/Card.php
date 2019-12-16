<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'goals';

    protected $fillable = [
        'match_id',
        'player_id',
        'goal_time',
        'isredcard',
    ];

    // Card 1-1 Player
    public function player(){
        return $this->hasOne('App\Goal', 'player_id');
    }
}
