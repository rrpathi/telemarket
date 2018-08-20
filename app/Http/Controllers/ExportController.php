<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customers;
use App\VendorCode;
use DB;


class ExportController extends Controller
{
    public function index(){
    	$customers =Customers::all();
        $datas = VendorCode::all();
    	$tables = DB::select('SHOW TABLES');
    	$locations = array();
    	$removeArray=array('admin_password_resets','admins','customers','migrations','password_resets','staff','staff_password_resets','students','users','vendor_codes');
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
    	return view('admin.export.index',compact('customers','locations', 'datas'));	
    }

    public function locationCount(){
        $location_name = request('location');
        $vendor_code=request('vendor_code');
        if (!empty($location_name)&&!empty($vendor_code)) {
            return $location_count = DB::table($location_name)->orWhere('vendor_code','like', '%' .$vendor_code . '%')->count();
        }else{
            return '';
        }

    }

    public function export(Request $request){
        $table_name = request('location');
        $skip = $request->from_count-1;
        $take = $request->to_count-$request->from_count+1;
        return $exportdata = DB::table($table_name)->orWhere('vendor_code','like', '%' .$request->vendor_code . '%')->skip($skip)->take($take)->get();
        // $lastInserted= DB::table($location)->orWhere('vendor_code', 'like', '%' .$request->vendor_code . '%')->orderBy('id', 'desc')->get()->first();

         dd(request()->all());
    }
}
