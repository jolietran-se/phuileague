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
        'uniform_number',
        'uniform_name',
        'birthday',
        'position',
        'role',
        'front_idcard',
        'backside_idcard',
        'phone',
        'ismain',
    ];
    //Player n-1 Club
    public function club(){
        return $this->belongsTo('App\User', 'owner_id');
    }
    
}
