<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class CalenderEntry extends Model
{
    //use SoftDeletes;

    protected $fillable = [
        'start',
        'finish',
        'subject',
        'color',
        'params',
        'deleted'
    ];

    //protected $dates = ['start', 'finish'];
}
