<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ad extends Model
{
    protected $fillable = ['code','type','page','status'];
}
