<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'type_code',
        'type_id',
        'name'
    ];


}
