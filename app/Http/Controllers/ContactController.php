<?php
namespace App\Http\Controllers;

use Excel;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Session;
use App\VendorCode;

class ContactController extends Controller
{
	public function index(){
		return view('add-student');
	}

	public function import(Request $request){
    	//validate the xls file
		$this->validate($request, array(
			'file'=> 'required'
		));

		if($request->hasFile('file')){
			$table_type = request('table_type');
			$extension = File::extension($request->file->getClientOriginalName());
			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
				$path = $request->file->getRealPath();
				$data = Excel::load($path, function($reader) {})->get();
				if(!empty($data) && $data->count()){
					$tables = DB::select('SHOW TABLES');
					foreach ($tables as $table) {
						foreach ($table as $key => $value){
							$table_name[] = $value;
						}
					}
					foreach ($data as $key => $value) {
						$exceldata[] = [
						'location' => $value->location,
						'database_type' => $value->database_type,
						'category' => $value->category,
						'vendor_code' => $value->vendor_code,
						'name' => $value->name,
						'mobile_no' => $value->mobile_no,
						'salary' => $value->salary,
						'email_id' => $value->email_id,
						'company_name' => $value->company_name,
						];
					}
					

					// location Array Excel 
					foreach ($exceldata as $key => $value) {
						// if ($value['name']!=""&&$value['mobile']!=""&&$value['location']!="") {
							$place[] = $value['location'];
							$locationArray[$value['location']][$key]['name'] = $value['name'];
							$locationArray[$value['location']][$key]['database_type'] = $value['database_type'];
							$locationArray[$value['location']][$key]['category'] = $value['category'];
							$locationArray[$value['location']][$key]['mobile_no'] = $value['mobile_no'];
							$locationArray[$value['location']][$key]['salary'] = $value['salary'];
							$locationArray[$value['location']][$key]['email_id'] = $value['email_id'];
							$locationArray[$value['location']][$key]['company_name'] = $value['company_name'];
						// }
					}

					 $excel_place = array_unique(array_map('strtolower', $place));
					 $new_location = array_diff($excel_place,$table_name);

					$newtableschema = array('tablename'=>$new_location,'colnames' => array('name', 'database_type','category','salary','email_id','company_name','vendor_code','vendor_name'));


					// Create Table
					if(!empty($new_location)){
						foreach ($newtableschema['tablename'] as $tablename) {
							Schema::create($tablename, function($table) use($newtableschema) {
								$table->increments('id')->unique(); //primary key 
								$table->string('mobile_no')->unique();       
								foreach($newtableschema['colnames'] as $col){
									$table->string($col)->nullable();
									}
								$table->timestamps();
							});
						}
					}



					// DATA INSERT
					foreach ($locationArray as $location => $locationData) {
						$location=strtolower($location);
						$lastInserted= DB::table($location)->orWhere('vendor_code', 'like', '%' .$request->vendor_code . '%')->orderBy('id', 'desc')->get()->first();
						if (!empty($lastInserted)) {
							$last = explode('_',$lastInserted->vendor_code);
							$last_id=end($last)+1;
						}else{
							$last_id=1;
						}
						$vendor_name= VendorCode::where('vendorid',$request->vendor_code)->get()->first();
						foreach ($locationData as $key => $value) {
						   try {
								$value['vendor_code']=$request->vendor_code.'_'.$last_id;
								$value['vendor_name']=$vendor_name->name;
					            $insertData = DB::table($location)->insert($value);
					            $last_id++; 
					        	} catch(\Illuminate\Database\QueryException $e){
					        }
						}
					}
					return back()->with('success','Contact Created Sucessfully');
				}
			}else {
				return back()->with('error','Check File Formate');
			}
		}
	}
}
