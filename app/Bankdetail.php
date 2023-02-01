<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bankdetail extends Model
{

    public $table='bank_details';
    protected $fillable = ['id','user_id','name','surname','bank_name','account_number','branch'];
	
	public function getNameAttribute($value) {		
        $value = substr($value,5);
		return base64_decode($value);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = Str::random(5).base64_encode($value);
    }	

	public function getSurnameAttribute($value) {
        $value = substr($value,5);
		return base64_decode($value);
    }

    public function setSurnameAttribute($value) {
        $this->attributes['surname'] = Str::random(5).base64_encode($value);
    }	
	
	public function getBankNameAttribute($value) {
        $value = substr($value,5);
		return base64_decode($value);
    }

    public function setBankNameAttribute($value) {
        $this->attributes['bank_name'] = Str::random(5).base64_encode($value);
    }	

	public function getAccountNumberAttribute($value) {
        $value = substr($value,5);
		return base64_decode($value);
    }

    public function setAccountNumberAttribute($value) {
        $this->attributes['account_number'] = Str::random(5).base64_encode($value);
    }	
	
	public function getBranchAttribute($value) {
        $value = substr($value,5);
		return base64_decode($value);
    }

    public function setBranchAttribute($value) {
        $this->attributes['branch'] = Str::random(5).base64_encode($value);
    }	
}
