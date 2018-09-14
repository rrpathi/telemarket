<?php

namespace App\Http\Controllers\staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\VendorCode;



class vendorController extends Controller
{
     public function __construct(){
        $this->middleware('staff');
    }
    public function index(){
    	return view('staff.vendor-code.add_vendorcode');
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

     public function view(){
        $datas = VendorCode::all();
        return view('staff.vendor-code.view_vendor',compact('datas'));
    }


    public function editVendor($id){
        $datas = VendorCode::findOrfail($id);
        return view('staff.vendor-code.edit-vendor',compact('datas'));
    }

    public function update_vendor($id,Request $request){
        $vendor = VendorCode::findOrfail($id);
        $vendor->name = request('name');
        $vendor->save();
        return back()->with('success','Vendor Updated Successfully');
    }
}
