<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalenderEntry extends Model
{
    protected $fillable = array('start', 'finish', 'subject' , 'color' , 'params' , 'deleted' );

    //protected $dates = ['start', 'finish'];
}
