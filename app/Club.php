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
        'club_type',
        'description'
    ];
}
