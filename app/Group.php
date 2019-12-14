<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'tournament_id',
        'number_match',
        'number_club',
        'number_to_knockout',
    ];
}
