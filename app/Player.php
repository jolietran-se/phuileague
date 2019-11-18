<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';

    protected $fillable = [
        'name',
        'avatar',
        'club_id',
        'identification',
        'phone',
        'birthday',
        'country',
        'uniform_number',
        'uniform_name'
    ];
    

}
