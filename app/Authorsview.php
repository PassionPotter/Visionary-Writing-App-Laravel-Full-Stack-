<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Authorsview extends Model
{
    use SoftDeletes;

    public $table='authors_view_count';
	
    public $fillable=['user_id','session_id'];
   
    public function user(){
       return  $this->belongsTo('App\User');
    }
}
