<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customers;
use DB;


class ExportController extends Controller
{
    public function index(){
    	$customers =Customers::all();
    	$tables = DB::select('SHOW TABLES');
    	$locations = array();
    	$removeArray=array('admin_password_resets','admins','customers','migrations','password_resets','staff','staff_password_resets','students','users');
    	 $tables = DB::select('SHOW TABLES');
		foreach ($tables as $table) {
			foreach ($table as $key => $value)
			$table_name[] = $value;
		}
    	foreach ($table_name as $key => $value) {
    		if(!in_array($value, $removeArray)){
    			$locations[] = $value; 
    		}
    	}
    	return view('admin.export.index',compact('customers','locations'));	
    }

    public function locationCount(){
        $location_name = request('location');
        if (!empty($location_name)) {
            return $location_count = DB::table($location_name)->count();
        }else{
            return '';
        }

    }
}
