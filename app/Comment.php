<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Comment extends Model
{
    //use SoftDeletes;
    //protected $dates=['deleted_at'];
    public $table='comments';
    public $fillable=['user_id','chapter_id','user_name','user_email','comment','status','approve','reply_to'];
    public function Chapter(){
        return $this->belongsTo(Chapter::class);
    }
}
