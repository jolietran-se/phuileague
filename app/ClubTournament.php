<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubTournament extends Model
{
    protected $table = 'club_tournament';

    protected $fillable = [
        'club_id',
        'tournament_id',
        'status',
        'group_id',
    ];

    // Club 1-n Player
    public function club(){
        return $this->belongsTo('App\Club', 'club_id');
    }
}
