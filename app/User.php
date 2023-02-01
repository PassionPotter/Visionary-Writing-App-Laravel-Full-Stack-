<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','reader', 'address','surname','phone','isVerified','active','verified','admin', 'email_token','username','lastname','number_code','phone_verified','approved_at','views'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       'name', 'password', 'email_token', 'remember_token'
    ];

    public function profile(){
      return  $this->hasOne('App\profile','user_id');
    }

    public function books(){
       return $this->hasMany('App\Book')->orderBy('book_order','asc');
    }

    public function authorsviews(){
       return $this->hasMany('App\Authorsview');
    }

}
