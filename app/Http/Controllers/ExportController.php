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
        if ($TempData['export_status']==0) {
            $exportHistoryData=ExportHistory::Where([['temp_datas_id',$TempData['id']],['vendor_code',$request->vendor_code],['location',$request->location],['category',$request->category]])->get();

            if(!empty($exportHistoryData)){
                foreach ($exportHistoryData as $key => $export) {
                    $datas=$export;
                    if(($export['from_count']>=$request->from_count) && ($export['from_count']<=$request->to_count)){
                        return back()->with('danger','Already Data Insert Form : '.$export['from_count'].' .To count '.$export['to_count']);
                        // echo "count from in";

                    }elseif(($export['to_count']>=$request->from_count) && ($export['to_count']<=$request->to_count)){
                         return back()->with('danger','Already Data Insert Form : '.$export['from_count'].' .To count '.$export['to_count']);
                        // echo "count to in";

                    }elseif(($export['from_count']<=$request->from_count) && ($request->to_count<=$export['to_count'])){
                         return back()->with('danger','Already Data Insert Form : '.$export['from_count'].' .To count '.$export['to_count']);
                        // echo "export Center content";

                    }elseif(($export['from_count']>=$request->from_count) && ($request->to_count>=$export['to_count'])){
                         return back()->with('danger','Already Data Insert Form : '.$export['from_count'].' .To count '.$export['to_count']);
                        // echo "on outer content";

                    }
                    
                }
           }
        }

      

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
            $data->save(); //update export status to tempdata table
            $exportHistoryData= ExportHistory::Where([['temp_datas_id',$TempData['id']]])->get();//get all data from export table
              foreach ($exportHistoryData as $key => $value) {
                    $skip = $value['from_count']-1;
                    $take = $value['to_count']-$value['from_count']+1;
                    $exportdata[] = DB::table($value['location'])->select('mobile_no','name','database_type','category','salary','email_id','company_name','vendor_name')->Where([['vendor_id',$value['vendor_code']],['category',$value['category']]])->skip($skip)->take($take)->get()->toArray();
              }
              foreach ($exportdata as $key => $value) {
                foreach ($value as $key => $value1) {
                    $finalData[] =json_decode( json_encode($value1), true);
                }
              }
            $exportdata= json_decode( json_encode($finalData), true);
             Excel::create('test',function($excel) use ($exportdata){
               $excel->sheet('Sheet 1',function($sheet) use ($exportdata){
                   $sheet->fromArray($exportdata);
               });
            })->export('xlsx');
             return back();
        }
        else{
            return back()->with('success','Data Submitted Sucessfully'); 
        }
    }
}
