<?php

namespace App\Http\Controllers;

use Excel;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Session;

class ContactController extends Controller
{
	public function index()
	{
		return view('add-student');
	}

	public function import(Request $request){
    	//validate the xls file
		$this->validate($request, array(
			'file'      => 'required'
		));

		if($request->hasFile('file')){
			$extension = File::extension($request->file->getClientOriginalName());
			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

				$path = $request->file->getRealPath();
				$data = Excel::load($path, function($reader) {
				})->get();
				if(!empty($data) && $data->count()){
					$tables = DB::select('SHOW TABLES');
					foreach ($tables as $table) {
						foreach ($table as $key => $value)
							$table_name[] = $value;

					}
					foreach ($data as $key => $value) {
						$exceldata[] = [
						'location' => $value->location,
						'name' => $value->name,
						'mobile' => $value->mobile,
						];
					}
					
					//location Array Excel 
					foreach ($exceldata as $key => $value) {
						if ($value['name']!=""&&$value['mobile']!=""&&$value['location']!="") {
							$place[] = $value['location'];
							$locationArray[$value['location']][$key]['name'] = $value['name'];
							$locationArray[$value['location']][$key]['mobile'] = $value['mobile'];
							$locationArray[$value['location']][$key]['location'] = $value['location'];
						}
					}
					$excel_place = array_unique($place);
					$excel_place = array_map('strtolower', $excel_place);
					$new_location = array_diff($excel_place,$table_name);
					$newtableschema = array('tablename'=>$new_location,'colnames' => array('name', 'location'));
						// Create Table
					if(!empty($new_location)){
						foreach ($newtableschema['tablename'] as $tablename) {
						Schema::create($tablename, function($table) use($newtableschema) {
							$table->increments('id')->unique(); //primary key 
							$table->string('mobile')->unique();       
							foreach($newtableschema['colnames'] as $col){
								$table->string($col);
								}
							});
						}
					}
						//data insert
					foreach ($locationArray as $location => $locationData) {
						foreach ($locationData as $key => $value) {
						   try {
					            $insertData = DB::table($location)->insert($value); 
					        } catch(\Illuminate\Database\QueryException $e){
					        }
						}
					}
					 return back()->with('success','Contact Created Sucessfully');
				}
				// return back();
			}else {
				// Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
				// return back();
			}
		}
	}
}

