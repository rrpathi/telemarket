<?php

namespace App\Http\Controllers;

use App\Staff;
use App\customers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
     public function Staff(){
        $totalStaffs = Staff::all()->count();
        $totalCustomers = customers::all()->count();
        // $data['unapproved_staff'] = Staff::where('verified','>',0)-> get()->count();
         return view('admin.home', compact('totalStaffs','totalCustomers'));
    }

}
