<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerPosition extends Model
{
    protected $table = 'player_positions';

    protected $fillable = [
        'name',
        'description'
    ];
}
