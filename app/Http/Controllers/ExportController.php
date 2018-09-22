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


    public function location_change(){
        if (!empty(request('location'))) {
            $database_type= DB::table(request('location'))->select('database_type')->get()->unique('database_type')->toArray();
            $optionData='<select class="form-control database_type_change"  id="database_type" name="database_type" required="">
           <option value="">Select Type</option>';
            foreach ($database_type as $key => $value) {
                $optionData = $optionData.'<option value="'.$value->database_type.'">'.$value->database_type.'</option>';
            }
            $finalData=$optionData.'</select>';
            return $finalData;
        }else{
            return '';
        }

    }

    public function database_type_change(){
        if (!empty(request('location'))&&!empty(request('database_type'))) {
            $location_count = DB::table(request('location'))->select('category')->Where('database_type',request('database_type'))->get();
            $location_count= $location_count->unique('category')->toArray();
            $optionData='<select class="form-control catagory_change"  id="category" name="category" required="">
           <option value="">Select Catagory</option>';
            foreach ($location_count as $key => $value) {
                $optionData = $optionData.'<option value="'.$value->category.'">'.$value->category.'</option>';
            }
            $optionData=$optionData.'</select>';
            return $optionData;
        }else{
            return '';
        }
    }

    public function catagory_change(){
//        return request()->all();
       $catagoryValues = DB::table(request('location'))->select('vendor_id')->Where([['database_type',request('database_type')],['category',request('category_value')]])->get();
        $catagoryValues= $catagoryValues->unique('vendor_id')->toArray();
        $optionData='<select class="form-control export_data_count" id="vendor_code" name="vendor_code" required="">
           <option value="">Select Vendor Code</option>';

        foreach ($catagoryValues as $key => $value) {
            $Vendor= VendorCode::where('vendorid',$value->vendor_id)->get()->first();
            $optionData = $optionData.'<option value="'.$value->vendor_id.'">'.$Vendor->name.'</option>';
        }
        $optionData=$optionData.'</select>';
        return $optionData;

    }


   public function customerExportCount(){
        if (!empty(request()->customer_id)) {
           $TempData = TempData::Where([['customer_id',request()->customer_id],['export_status',0]])->orderBy('id', 'DESC')->first();
           if(empty($TempData)){
            return '';
           }
            // return $TempData['remaining_count'];
             $exportHistoryData=ExportHistory::with('vendor')->Where([['temp_datas_id',$TempData['id']]])->get();

             $table = '<table class="table"><thead>
        <th>Location</th>
        <th>Category</th>
        <th>Vendor Code</th>
        <th>From</th>
        <th>To</th>
        <th>Export Count</th>
        <th>Action</th>
    </thead>
    <tbody>';
             foreach ($exportHistoryData as $key => $value) {
                $table = $table.'<tr><td>'.$value['location'].'</td><td>'.$value['category'].'</td><td>'.$value['vendor']['name'].'</td><td>'.$value['from_count'].'</td><td>'.$value['to_count'].'</td><td>'.$value['export_count'].'</td><td>
                <form action="'. route("admin.destory_export", $value["id"]) .'" method="POST">'.
                           csrf_field().'
                           <input type="hidden" name="_method" value="DELETE">

                <a href="export/'.$value['id'].'/edit"  class="btn btn-default">Edit</a>

                <button onclick="return confirm(\'Are you sure?\')" class="btn btn-default">Delete</button>
                </form>
                </td></tr>';
             }
            $table = $table.'</tbody></table>';
            $finalDatas['count']=$TempData['remaining_count'];
            $finalDatas['table']=$table;
            if(empty($exportHistoryData)){
                return "";
            }else{
                return $finalDatas;
            }
        }
   }

//Save datas in Temp_data
    public function export(Request $request){
        $this->validate(request(),[
            'customer_id'=>'required',
            'location'=>'required',
            'database_type'=>'required',
            'category'=>'required',
            'from_count'=>'required',
            'to_count'=>'required',
            'category'=>'required',
            'customer_count'=>'required',
        ]);
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

        // EXPORT MODULE
//        if($data['remaining_count']==0){
//            $data = TempData::find($TempData['id']);
//            $data['export_status']=1;
//            $data->save(); //update export status to tempdata table
//            $exportHistoryData= ExportHistory::Where([['temp_datas_id',$TempData['id']]])->get();//get all data from export table
//              foreach ($exportHistoryData as $key => $value) {
//                    $skip = $value['from_count']-1;
//                    $take = $value['to_count']-$value['from_count']+1;
//                    $exportdata[] = DB::table($value['location'])->select('name','database_type','category','salary','mobile_no','telephone','email_id','company_name','vendor_name')->Where([['vendor_id',$value['vendor_code']],['category',$value['category']]])->skip($skip)->take($take)->get()->toArray();
//              }
//              foreach ($exportdata as $key => $value) {
//                foreach ($value as $key => $value1) {
//                    $finalData[] =json_decode( json_encode($value1), true);
//                }
//              }
//            $exportdata= json_decode( json_encode($finalData), true);
//             Excel::create('Greefi-Tech',function($excel) use ($exportdata){
//               $excel->sheet('Sheet 1',function($sheet) use ($exportdata){
//                   $sheet->fromArray($exportdata);
//               });
//            })->export('xlsx');
//             return back();
//        }
//        else{
            return back()->with('success','Data Submitted Sucessfully'); 
//        }
    }

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
        return view('admin.export.edit',compact('customers','locations', 'datas','export_history','TempData'));
    }

// DELETE EXPORT 
    public function deleteExport($id){
        $export_history = ExportHistory::findOrFail($id);
        $temp_datas_id=$export_history->temp_datas_id;
        $export_count=$export_history->export_count;
        $data= TempData::findOrfail($temp_datas_id);
        $data ->remaining_count=$data['remaining_count']+$export_history->export_count;
        $data->save();
        ExportHistory::where('id', $id)->delete();
        return back()->with('success','Data Deleted Sucessfully');
    }


    public function updateExport(Request $request,$id){
        $this->validate(request(),[
            'location'=>'required',
            'database_type'=>'required',
            'category'=>'required',
            'from_count'=>'required',
            'to_count'=>'required',
            'category'=>'required',
        ]);
        // return $request;
        $export_history_data = ExportHistory::findOrFail($id);
        $TempTableData = TempData::Where([['id',$export_history_data['temp_datas_id']]])->first();

        // CHECK THE REMAINING COUNT EXCEED
        if($TempTableData->remaining_count+$export_history_data->export_count-$request->export_count<0){
            return back()->with('danger','Your Data Limit is Exceed');
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

        // EXPORT MODULE
//        if($remaining_updated_data==0){
//            $data = TempData::find($export_history_data->temp_datas_id);
//            $data['export_status']=1;
//            $data->save(); //update export status to tempdata table
//            $exportHistoryData= ExportHistory::Where([['temp_datas_id',$TempTableData->id]])->get();//get all data from export table
//              foreach ($exportHistoryData as $key => $value) {
//                    $skip = $value['from_count']-1;
//                    $take = $value['to_count']-$value['from_count']+1;
//                    $exportdata[] = DB::table($value['location'])->select('name','database_type','category','salary','mobile_no','telephone','email_id','company_name','vendor_name')->Where([['vendor_id',$value['vendor_code']],['category',$value['category']]])->skip($skip)->take($take)->get()->toArray();
//              }
//              foreach ($exportdata as $key => $value) {
//                foreach ($value as $key => $value1) {
//                    $finalData[] =json_decode( json_encode($value1), true);
//                }
//              }
//            $exportdata= json_decode( json_encode($finalData), true);
//             Excel::create('Greefi-Tech',function($excel) use ($exportdata){
//               $excel->sheet('Sheet 1',function($sheet) use ($exportdata){
//                   $sheet->fromArray($exportdata);
//               });
//            })->export('xlsx');
//             return back();
//        }
//        else{
            return redirect('admin/export')->with('success', 'Export Data updated Sucessfully!');
//        }
    }

    public function ExportApproval(Request $request){
        $customers =Customers::all();
        return view('admin.export.exportApproval',compact('customers')); 
    }

    public function getExportApprovalStatus(Request $request){
        $TempData = TempData::with('staff')->Where([['customer_id',request()->customer_id]])->orderBy('id', 'DESC')->first();
        $exportHistoryData=ExportHistory::Where([['temp_datas_id',$TempData['id']]])->get();
        $table = '<table class="table"><thead>
        <th>Location</th>
        <th>Category</th>
        <th>Vendor Code</th>
        <th>From</th>
        <th>To</th>
        <th>Export Count</th>
        <th>Action</th>
    </thead>
    <tbody>';
             foreach ($exportHistoryData as $key => $value) {
                $table = $table.'<tr><td>'.$value['location'].'</td><td>'.$value['category'].'</td><td>'.$value['vendor_code'].'</td><td>'.$value['from_count'].'</td><td>'.$value['to_count'].'</td><td>'.$value['export_count'].'</td><td>
                <form action="'. route("admin.destory_export", $value["id"]) .'" method="POST">'.
                           csrf_field().'
                           <input type="hidden" name="_method" value="DELETE">

                <a href="export/'.$value['id'].'/edit"  class="btn btn-default">Edit</a>

                <button onclick="return confirm(\'Are you sure?\')" class="btn btn-default">Delete</button>
                </form>
                </td></tr>';
             }
            $table = $table.'</tbody></table>';
            $finalDatas['table']=$table;
            $finalDatas['tempData']=$TempData;
        if(!empty($TempData)){
            if($TempData->remaining_count==0 && $TempData->export_status==0){
                if(empty($exportHistoryData)){
                    return "";
                }else{
                    return $finalDatas;

                }
            }else{
                return '';
            }
        }
    }




    public function updateApprovalStatus(Request $request){
        // return $request;
        $TempData = TempData::Where([['customer_id',request()->customer_id]])->orderBy('id', 'DESC')->first();
        $data = TempData::find($TempData->id);
        if($TempData->staffIds==0 && $request->approvedStatus==1){
            $data['export_status']=1;
        }
        $data['approvedStatus']=$request->approvedStatus;
        $data['discription']=$request->discription;
        if($data->save()){
            return back()->with('success','Export Status Updated Successfully!!');
        }else{
            return back()->with('danger','Error on update..');
            
        }
    }


    // list Export File Lists
    public function ViewExportLIst(Request $request){
        $datas = TempData::with('customer','staff')->where([['approvedStatus',1],['remaining_count',0]])->orderBy('id', 'DESC')->get();
        return view('admin.export.export_excel',compact('datas'));
    }

    public function DownloadExcelData($id,Request $request){
            $data = TempData::find($id);
            $exportHistoryData= ExportHistory::Where([['temp_datas_id',$data->id]])->get();//get all data from export table
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
    }




// CHECK LAST ONE MONTH DATA EXPORT
    public function OneMonthCheckExportData(Request $request){
        $date = \Carbon\Carbon::today()->subDays(30);
// return ExportHistory::where([['customer_id',$request->customer_id],['updated_at', '>=', date($date)]])->get();
        if(!empty($request->from_count) && !empty($request->to_count) && !empty($request->customer_id) && !empty($request->category_value) && !empty($request->database_type) && !empty($request->location) && !empty($request->vendor_code)){
             
             $exportHistoryData= ExportHistory::with('TempData')->Where([['customer_id',$request->customer_id],['location',$request->location],['database_type',$request->database_type],['category',$request->category_value],['vendor_code',$request->vendor_code],['updated_at', '>=', date($date)]])->get();
             
            if(!empty($exportHistoryData)){
                foreach ($exportHistoryData as $key => $data) {
                    if ($data->TempData->export_status==1) {
                        // return $data;
                        if(($data['from_count']>=$request->from_count) && ($data['from_count']<=$request->to_count)){
                            return $data['error']='Data Already Exported Form Count : '.$data->from_count.' to To Count : '.$data->to_count.' On : '.$data->TempData->updated_at;

                            // echo "count from in";
                        }elseif(($data['to_count']>=$request->from_count) && ($data['to_count']<=$request->to_count)){
                            return $data['error']='Data Already Exported Form Count : '.$data->from_count.' to To Count : '.$data->to_count.' On : '.$data->TempData->updated_at;
                            // echo "count to in";

                        }elseif(($data['from_count']<=$request->from_count) && ($request->to_count<=$data['to_count'])){
                            return $data['error']='Data Already Exported Form Count : '.$data->from_count.' to To Count : '.$data->to_count.' On : '.$data->TempData->updated_at;
                            // echo "data Center content";
                        }elseif(($data['from_count']>=$request->from_count) && ($request->to_count>=$data['to_count'])){
                            return $data['error']='Data Already Exported Form Count : '.$data->from_count.' to To Count : '.$data->to_count.' On : '.$data->TempData->updated_at;
                            // echo "on outer content";
                        }
                    }
                }
            }
        }else{
            return '';
        }
    }
}
