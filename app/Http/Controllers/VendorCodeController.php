<?php

namespace App\Http\Controllers;

use App\VendorCode;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class VendorCodeController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function index(){
    	return view('admin.vendorcode.add_vendorcode');
    }
    public  function  store(Request $request){
       // dd(request()->all());
        $this->validate(request(),[
            'name'=>'required'
        ]);
        VendorCode::create([
            'name'=>request('name'),
            'vendorid' => Helper::generate_code(VendorCode::latest()->first(), "vendor")
          
        ]);
        return back()->with('success','New VendorCode Created Successfully');
    }

}
