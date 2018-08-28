<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customers;
use App\VendorCode;
use DB;
use Excel;
use App\ExportHistory;


class ExportController extends Controller
{
    public function index(){
    	$customers =Customers::all();
        $datas = VendorCode::all();
    	$tables = DB::select('SHOW TABLES');
    	$locations = array();
    	$removeArray=array('admin_password_resets','admins','customers','migrations','password_resets','staff','staff_password_resets','students','users','vendor_codes','customer_export_history','block_lists');
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

    public function locationCount(Request $request){
        $location = request('location');
        $vendor_code=request('vendor_code');
        $database_type=request('database_type');
        $category_value=request('category_value');
        if (!empty($location)&&!empty($database_type)&&!empty($category_value)) {
            return $location_count = DB::table($location)->Where([['database_type', '=', $database_type],['category', '=', $category_value],['vendor_id', '=', $vendor_code]])->count();
        }else{
            return '';
        }

    }

   
   public function catagoryChange(){
    if (!empty(request('location'))&&!empty(request('category_value'))) {
            $location_count = DB::table(request('location'))->select('category')->Where('database_type',request('category_value'))->get();
           $location_count= $location_count->unique('category')->toArray();
           $optionData='<select class="form-control export_change"  id="category" name="category" required=""><option value="">Select Catagory</option>';
            foreach ($location_count as $key => $value) {
                $optionData = $optionData.'<option value="'.$value->category.'">'.$value->category.'</option>';
            }
            $optionData=$optionData.'</select>';
            return $optionData;

    }else{
        return '';
    }

   }

    public function export(Request $request){
        $table_name = request('location');
        $skip = $request->from_count-1;
        $take = $request->to_count-$request->from_count+1;

        // return $request->all();

        $ExportHistory= ExportHistory::Where([['customer_id',$request->customer_id],['location',$request->location],['category',$request->category],['vendor_code',$request->vendor_code],['from_count',$request->from_count],['to_count',$request->to_count]])->first();

        if (empty($ExportHistory)) {
            $exportdata = DB::table($table_name)->select('mobile_no','name','database_type','category','salary','email_id','company_name','vendor_name')->orWhere('vendor_code','like', '%' .$request->vendor_code . '%')->skip($skip)->take($take)->get();
            $exportdata= json_decode( json_encode($exportdata), true);
            $column_values = array('customer_id'=>$request->customer_id,'vendor_code'=>$request->vendor_code,'location'=>$request->location,'category'=>$request->category, 'from_count'=>$request->from_count,'to_count'=>$request->to_count,'export_count'=>$take);
            $export_data_histroy = DB::table('customer_export_history')->insert($column_values);

            Excel::create($table_name,function($excel) use ($exportdata){
               $excel->sheet('Sheet 1',function($sheet) use ($exportdata){
                   $sheet->fromArray($exportdata);
               });
            })->export('xlsx');
        }
        else{
            return back()->with('danger','Sorry!  You Are Already Downloaded '); 
        }
        
        
    }
    

}
