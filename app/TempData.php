<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempData extends Model
{
    public $guarded = ['id', 'created_at', 'updated_at'];

    public function customer(){
    	return $this->hasOne('App\Customers','id','customer_id');
    }

    public function staff(){
    	return $this->hasOne('App\Staff','id','staffIds');
    }
}
