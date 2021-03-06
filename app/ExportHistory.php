<?php

namespace App;
use App\Customers;
use Illuminate\Database\Eloquent\Model;

class ExportHistory extends Model
{
	public $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'customer_export_history';

    public function customer(){
    	return $this->hasOne('App\Customers','id','customer_id');
    }
    public function vendor(){
    	return $this->hasOne('App\VendorCode','vendorid','vendor_code');
    }

    public function TempData(){
    	return $this->hasOne('App\TempData','id','temp_datas_id');
    }
}
