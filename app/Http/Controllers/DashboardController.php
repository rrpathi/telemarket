<?php

namespace App\Http\Controllers;

use App\Staff;
use DB;
use App\Customers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
     public function Staff(){
     	$totalStaffs=0;
     	$totalCustomers=0;
        $totalStaffs = Staff::all()->count();

        $totalCustomers = Customers::all()->count();
        // $data['unapproved_staff'] = Staff::where('verified','>',0)-> get()->count();

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
        $PlaceDataCount=array();
        foreach ($locations as $key => $value) {
            $PlaceDataCount[$value]['salaried'] = DB::table($value)->where('database_type', '=', 'salaried')->count();
            $PlaceDataCount[$value]['business'] = DB::table($value)->where('database_type', '=', 'business')->count();


    //         $PlaceDataCount[]=[
    //     'salaried'      =>DB::table($value)->where('database_type', '=', 'salaried')->count(),
    //     'business'     => DB::table($value)->where('database_type', '=', 'business')->count()
    // ];
        }
        // echo "<pre>";
        // print_r($PlaceDataCount);
        // return 1;
         return view('admin.home', compact('totalStaffs','totalCustomers','PlaceDataCount'));
    }

}
