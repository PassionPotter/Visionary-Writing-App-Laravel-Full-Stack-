<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Chapter;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use SoftDeletes;

    public $table='book';
    protected $dates=['deleted_at'];
    public $fillable=['title','book_order','description','status','complete','genre','book_cover','user_id','slug','created_at','views'];
    
    public function Chapters(){
        return $this->hasMany('App\Chapter');
    }

    public function user(){
       return  $this->belongsTo('App\User');
    }

    public function views(){
        return $this->hasMany('App\Views');
    }
}
