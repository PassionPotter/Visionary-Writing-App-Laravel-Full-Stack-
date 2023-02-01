<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Chapter extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];
    public $table='Chapter';
    public $fillable=['title','book_id','status','chapter_content','slug','created_at'];

    public function Comment(){
        return $this->hasMany('App\Comment');
    }

    public function Book(){
        return $this->belongsTo('App\Book');
    }
}
