<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RWords extends Model
{

    protected $table = 'rkeywords';
    
    protected $fillable = [
        'id','keyword','status'
    ];

}