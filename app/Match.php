<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matchs';

    protected $fillable = [
        'tournament_id',
        'stage',
        'group_id',
        'round',
        'date',
        'time',
        'address',
        'clubA_id',
        'clubB_id',
        'goalA',
        'goalB',
        'yellow_card_A',
        'yellow_card_B',
        'red_card_A',
        'red_card_B',
        'status',
    ];

    // Match n - 1 Tournament
    public function tournament(){
        return $this->belongsTo('App\Tournament', 'tournament_id');
    }

    // Match 1-n Goal
    public function goals(){
        return $this->hasMany('App\Goal', 'match_id');
    }

    // Match 1-n Card
    public function cards(){
        return $this->hasMany('App\Card', 'match_id');
    }
}
