<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    protected $fillable = [
        'match_id',
        'club_id',
        'player_id',
        'goal_time',
        'isredcard',
    ];

    // Card n-1 Player
    public function player(){
        return $this->belongsTo('App\Player', 'player_id');
    }
}
