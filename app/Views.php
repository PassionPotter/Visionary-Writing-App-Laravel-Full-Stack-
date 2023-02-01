<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Views extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];
    public $table='books_view_count';
    public $fillable=['book_id','session_id'];
    
    public function Book(){
        return $this->belongsTo(Book::class);
    }
}
