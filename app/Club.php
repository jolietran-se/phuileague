<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'clubs';

    protected $fillable = [
        'name',
        'owner_id',
        'logo',
        'uniform',
        'playeramount',
        'gender',
        'ages',
        'club_type_id',
        'description',
        'slug',
    ];

    // Club 1-n Player
    public function players(){
        return $this->hasMany('App\Player');
    }

    // Club n - 1 User
    public function user(){
        return $this->belongsTo('App\User', 'owner_id');
    }

}
