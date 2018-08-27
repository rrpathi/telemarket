<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customers;
use App\VendorCode;
use DB;
use Excel;


class ExportController extends Controller
{
    public function index(){
    	$customers =Customers::all();
        $datas = VendorCode::all();
    	$tables = DB::select('SHOW TABLES');
    	$locations = array();
    	$removeArray=array('admin_password_resets','admins','customers','migrations','password_resets','staff','staff_password_resets','students','users','vendor_codes','customer_export_history');
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
        $exportdata = DB::table($table_name)->select('mobile_no','name','database_type','category','salary','email_id','company_name','vendor_name')->orWhere('vendor_code','like', '%' .$request->vendor_code . '%')->skip($skip)->take($take)->get();
        $exportdata= json_decode( json_encode($exportdata), true);
        $column_values = array('customer_id'=>$request->customer_id,'vendor_code'=>$request->vendor_code,'location'=>$request->location,'from_count'=>$request->from_count,'to_count'=>$request->to_count,'export_count'=>$take);
        $export_data_histroy = DB::table('customer_export_history')->insert($column_values);

         Excel::create($table_name,function($excel) use ($exportdata){
           $excel->sheet('Sheet 1',function($sheet) use ($exportdata){
               $sheet->fromArray($exportdata);
           });
       })->export('xlsx');
        
    }
   
   public function catagoryChange(){
    if (!empty(request('location'))&&!empty(request('category_value'))) {
            $location_count = DB::table(request('location'))->select('category')->Where('database_type',request('category_value'))->get();
           $location_count= $location_count->unique('category')->toArray();
           $optionData='';
            foreach ($location_count as $key => $value) {
                $optionData = $optionData.'<option value="'.$value->category.'">'.$value->category.'</option>';
            }
            return $optionData;

    }else{
        return '';
    }

   }

}
