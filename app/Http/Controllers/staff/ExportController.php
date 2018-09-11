<?php

namespace App\Http\Controllers\staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        return view('staff.export.index',compact('customers','locations', 'datas'));    
    }




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
                $column_values = array('customer_id'=>$request->customer_id,'vendor_code'=>$request->vendor_code,'location'=>$request->location,'database_type'=>$request->database_type,'category'=>$request->category, 'from_count'=>$request->from_count,'to_count'=>$request->to_count,'export_count'=>$request->export_count,'temp_datas_id'=>$TempData['id']);
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
                $column_values = array('customer_id'=>$request->customer_id,'vendor_code'=>$request->vendor_code,'location'=>$request->location,'database_type'=>$request->database_type,'category'=>$request->category, 'from_count'=>$request->from_count,'to_count'=>$request->to_count,'export_count'=>$request->export_count,'temp_datas_id'=>$TempData['id']);
                $ExportHistoryInsert = ExportHistory::create($column_values);
                // return "Inserted";
            }else{
                return back()->with('danger','Sorry!  You Balance Count is :'.$TempData['remaining_count']); 
            }
        }

        
            return back()->with('success','Data Submitted Sucessfully'); 
    }


// EXPORT Request data
    public function dataExport(Request $request){
    	$customers =Customers::all();
        return view('staff.export.export_data',compact('customers'));
    }

    // CHECK EXPORT STATUS
    public function exportStatus(Request $request){
    	// return $request;
    	$TempData = TempData::Where([['customer_id',request()->customer_id]])->orderBy('id', 'DESC')->first();
    	if(!empty($TempData) && $TempData->export_status==0){
    		return $TempData;
    	}	
    }

    public function exportDataExcel(Request $request){
    	$TempData = TempData::Where([['customer_id',request()->customer_id]])->orderBy('id', 'DESC')->first();
    	if($TempData->approvedStatus==1 && $TempData->export_status==0 && $TempData->remaining_count==0){
    		$data = TempData::find($TempData['id']);
            $data['export_status']=1;
            $data->save(); //update export status to tempdata table
            $exportHistoryData= ExportHistory::Where([['temp_datas_id',$TempData['id']]])->get();//get all data from export table
              foreach ($exportHistoryData as $key => $value) {
                    $skip = $value['from_count']-1;
                    $take = $value['to_count']-$value['from_count']+1;
                    $exportdata[] = DB::table($value['location'])->select('name','database_type','category','salary','mobile_no','telephone','email_id','company_name','vendor_name')->Where([['vendor_id',$value['vendor_code']],['category',$value['category']]])->skip($skip)->take($take)->get()->toArray();
              }
              foreach ($exportdata as $key => $value) {
                foreach ($value as $key => $value1) {
                    $finalData[] =json_decode( json_encode($value1), true);
                }
              }
            $exportdata= json_decode( json_encode($finalData), true);
             Excel::create('Greefi-Tech',function($excel) use ($exportdata){
               $excel->sheet('Sheet 1',function($sheet) use ($exportdata){
                   $sheet->fromArray($exportdata);
               });
            })->export('xlsx');
             return back();
    	}else{
    		return back()->with('danger','Error On download'); 
    	}
    	
    }









// EDIT EXPORT DATA
    public function editExport($id){
        $export_history = ExportHistory::findOrFail($id);
        $TempData = TempData::where([['id',$export_history['temp_datas_id']]])->get();
        
        // print_r($TempData);

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
        return view('staff.export.edit',compact('customers','locations', 'datas','export_history','TempData'));
    }












// UPDATE EXPORT DATA
    public function updateExport(Request $request,$id){
        // return $request;
        $export_history_data = ExportHistory::findOrFail($id);
        $TempTableData = TempData::Where([['id',$export_history_data['temp_datas_id']]])->first();

        // CHECK THE REMAINING COUNT EXCEED
        if($TempTableData->remaining_count+$export_history_data->export_count-$request->export_count<0){
            return back()->with('danger','Your Data Limit is Exceed');
        }
        // CHECK EXPORT STATUS
        if($TempTableData->export_status==1){
            return back()->with('danger','Already Excel Exported');
        }

        // REMOVE THIS DATA TO CHECK IS BETWEEN
         $exportHistoryData=ExportHistory::Where([['temp_datas_id',$TempTableData['id']],['vendor_code',$request->vendor_code],['location',$request->location],['category',$request->category]])->get();
        foreach ($exportHistoryData as $key => $value) {
            if ($value->id==$id) {
                unset($exportHistoryData[$key]);
            }
        }
        // return $exportHistoryData;
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

        $remaining_updated_data=$TempTableData->remaining_count+$export_history_data->export_count-$request->export_count;
            if($remaining_updated_data>=0){
                $data = ExportHistory::find($id);
                $data ->location =  request('location');
                $data ->category =  request('category');
                $data ->vendor_code =  request('vendor_code');
                $data ->from_count =  request('from_count');
                $data ->to_count =  request('to_count');
                $data ->export_count =  request('export_count');
                if($data->save()){
                    $updateTempData = TempData::findOrFail($export_history_data->temp_datas_id);
                    $updateTempData ->remaining_count =  $remaining_updated_data;
                    $updateTempData->save();
                }
            }
        return back()->with('success', 'Export Data updated Sucessfully!');
    }

}