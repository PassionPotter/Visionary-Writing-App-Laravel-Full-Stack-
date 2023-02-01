<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    protected $table='profiles';
    protected $fillable=['avatar','user_id','about','dob','gender'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
