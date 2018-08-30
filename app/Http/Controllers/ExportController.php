<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customers;
use App\VendorCode;
use DB;
use Excel;
use App\ExportHistory;
use App\TempData;


class ExportController extends Controller
{
    public function index(){
    	$customers =Customers::all();
        $datas = VendorCode::all();
    	$tables = DB::select('SHOW TABLES');
    	$locations = array();
    	$removeArray=array('admin_password_resets','admins','customers','migrations','password_resets','staff','staff_password_resets','students','users','vendor_codes','customer_export_history','block_lists','temp_datas');
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

   public function customerExportCount(){
        if (!empty(request()->customer_id)) {
            $TempData = TempData::Where([['customer_id',request()->customer_id],['export_status',0]])->orderBy('id', 'DESC')->first();
            return $TempData['remaining_count'];
        }
   }

//Save datas in Temp_data
    public function export(Request $request){
        //check temp_datas empty or not
        $TempData = TempData::Where([['customer_id',$request->customer_id]])->orderBy('id', 'DESC')->first();
        // return $request->all();
        if(empty($TempData) || $TempData['export_status']==1){
            // if temp_datas table is empty to particular customer create new temp data
            if ($request->customer_count-$request->export_count>=0) { //Customer Count less if User Enter more Count
                 $data['customer_id']=$request->customer_id;
                $data['customer_count']=$request->customer_count;
                $data['remaining_count']=$request->customer_count-$request->export_count;
                $TempData= TempData::create($data);
                $column_values = array('customer_id'=>$request->customer_id,'vendor_code'=>$request->vendor_code,'location'=>$request->location,'category'=>$request->category, 'from_count'=>$request->from_count,'to_count'=>$request->to_count,'export_count'=>$request->export_count,'temp_datas_id'=>$TempData['id']);
                $ExportHistoryInsert = ExportHistory::create($column_values);
                // return "Inserted";
            }else{
               return back()->with('danger','Sorry!  You Are Data limit Exceed.You Gave :'.$request->customer_count.'.But your Export Data Count is: '.$request->export_count); 
            }
        }else{
            if ($TempData['remaining_count']-$request->export_count>=0) {
                $data = TempData::find($TempData['id']);
                $data['remaining_count']=$TempData['remaining_count']-$request->export_count;
                $data->save();
                $column_values = array('customer_id'=>$request->customer_id,'vendor_code'=>$request->vendor_code,'location'=>$request->location,'category'=>$request->category, 'from_count'=>$request->from_count,'to_count'=>$request->to_count,'export_count'=>$request->export_count,'temp_datas_id'=>$TempData['id']);
                $ExportHistoryInsert = ExportHistory::create($column_values);
                // return "Inserted";
            }else{
                return back()->with('danger','Sorry!  You Balance Count is :'.$TempData['remaining_count']); 
            }
        }

        // EXPORT MODULE
        if($data['remaining_count']==0){
            $data = TempData::find($TempData['id']);
            $data['export_status']=1;
            $data->save();
            return $exportHistoryData= ExportHistory::Where([['temp_datas_id',$TempData['id']]])->get();
            foreach ($exportHistoryData as $key => $value) {
                
            }

        }else{
            return "not export";
        }

        // $table_name = request('location');
        // $skip = $request->from_count-1;
        // $take = $request->to_count-$request->from_count+1;

        // // return $request->all();

        // $ExportHistory= ExportHistory::Where([['customer_id',$request->customer_id],['location',$request->location],['category',$request->category],['vendor_code',$request->vendor_code],['from_count',$request->from_count],['to_count',$request->to_count]])->first();

        // if (empty($ExportHistory)) {
        //     $exportdata = DB::table($table_name)->select('mobile_no','name','database_type','category','salary','email_id','company_name','vendor_name')->orWhere('vendor_code','like', '%' .$request->vendor_code . '%')->skip($skip)->take($take)->get();
        //     $exportdata= json_decode( json_encode($exportdata), true);
        //     $column_values = array('customer_id'=>$request->customer_id,'vendor_code'=>$request->vendor_code,'location'=>$request->location,'category'=>$request->category, 'from_count'=>$request->from_count,'to_count'=>$request->to_count,'export_count'=>$take);
        //     $export_data_histroy = DB::table('customer_export_history')->insert($column_values);

        //     Excel::create($table_name,function($excel) use ($exportdata){
        //        $excel->sheet('Sheet 1',function($sheet) use ($exportdata){
        //            $sheet->fromArray($exportdata);
        //        });
        //     })->export('xlsx');
        // }
        // else{
        //     return back()->with('danger','Sorry!  You Are Already Downloaded '); 
        // }
        
        
    }
    

}
