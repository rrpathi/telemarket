<?php

namespace App\Http\Controllers\staff;
use App\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
 
	public function index(){
    	return view('staff.customer.add-customer');
	}


 	public  function  addCustomer(Request $request){
        $this->validate(request(),[
            'name'=>'required',
        ]);
        Customers::create([
            'name'=>request('name'),
           
        ]);
        return back()->with('success','New Customer Created Successfully');
    }   
    public function viewCustomer(Request $request){
    	  $datas = Customers::all();
        return view('staff.customer.view-customer',compact('datas'));
    }

    public function editCustomer($id){
        $datas = Customers::findOrfail($id);
        return view('staff.customer.edit-customer',compact('datas'));
    }
    public function updateCustomer($id,Request $request){
        $staff = Customers::findOrfail($id);
        $staff->name = request('name');
        $staff->save();
        return back()->with('success','Customer Updated Successfully');
    }
}
