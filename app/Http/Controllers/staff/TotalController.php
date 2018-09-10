<?php

namespace App\Http\Controllers\staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VendorCode;


class TotalController extends Controller
{
    public function contactForm(){
    	 $datas = VendorCode::all();
    	return view('staff.contacts.add-contacts', compact('datas'));
    }
}
