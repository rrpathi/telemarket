<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;
use DB;


class ExportController extends Controller
{
    public function index(){
    	$customers =Customers::all();
    	$tables = DB::select('SHOW TABLES');
    	$locations = array();
    	$removeArray=array('admin_password_resets','admins','customers','migrations','password_resets','staff','staff_password_resets','students','users');

    	foreach ($tables as $key => $value) {
    		if(!in_array($value->Tables_in_telemarketing, $removeArray)){
    			$locations = array_merge($locations,array($value->Tables_in_telemarketing)); 
    		}
    	}
    	
    	


    	return view('admin.export.index',compact('customers','locations'));	
    }
}
