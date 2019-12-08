<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentPlayer extends Model
{
    protected $table = "tournament_players";

    protected $fillable = [
        'club_tournament_id',
        'name',
        'avatar',
        'uniform_number',
        'uniform_name',
        'position',
        'role',
        'phone',
        'birthday',
    ];

    // Player n-1 Tournament-Club
    public function tournament(){
        return $this->belongsTo('App\ClubTournament', 'club_tournament_id');
    }
}
