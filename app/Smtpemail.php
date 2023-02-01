<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Smtpemail extends Model
{
    public $table='smtpemail';

    public $fillable=['MAIL_DRIVER','MAIL_HOST','MAIL_PORT','MAIL_USERNAME','MAIL_PASSWORD','MAIL_FROM_ADDRESS','created_at'];

}
