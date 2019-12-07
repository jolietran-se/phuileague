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
    ];
}
