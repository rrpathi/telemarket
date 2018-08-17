<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;

class ExportController extends Controller
{
    public function index(){
    	$customers =Customers::all();
    	return view('admin.export.index',compact('customers'));	
    }
}
