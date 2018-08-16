<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
     public function Staff(){
     	// return "hello";
        // $data['total_staff'] = Staff::all()->count();
        // $data['unapproved_staff'] = Staff::where('verified','>',0)-> get()->count();
         return view('admin.home', compact('data'));
    }

}
