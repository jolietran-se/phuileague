<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubType extends Model
{
    protected $table = "club_type_ages";

    protected $fillable = [
        'name',
        'description'
    ];
}
