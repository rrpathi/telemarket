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

    public function view(){
        $datas = VendorCode::all();
        return view('admin.vendorcode.view_vendor',compact('datas'));
    }


    public function editVendor($id){
        $datas = VendorCode::findOrfail($id);
        return view('admin.vendorcode.edit-vendor',compact('datas'));
    }

    public function update_vendor($id,Request $request){
        $vendor = VendorCode::findOrfail($id);
        $vendor->name = request('name');
        $vendor->save();
        return back()->with('success','Vendor Updated Successfully');
    }

    public function deleteCustomer($id){
        $Request = VendorCode::findOrfail($id);
        $Request->delete();
        return back()->with('success','Vendor Deleted Successfully');
    }

}
