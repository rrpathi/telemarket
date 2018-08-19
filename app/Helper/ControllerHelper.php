<?php

namespace App\Helpers;
class Helper
{

	public static function test(){
		return VendorCode::all();
	}

	public static function generate_code($last_data, $slug){
	    $id = 0;
	    if(!is_null ($last_data)) {
	      $id = $last_data->id;
	    }
	    return $slug.($id+1);
	}
}