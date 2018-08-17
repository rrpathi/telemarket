<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
    	return view('admin.customers.add-customer');
    }
    public  function  store(Request $request){
        $this->validate(request(),[
            'name'=>'required',
            'email'=>'required|unique:customers',
            'mobilenumber'=>'required',
            'password'=>'required',
        ]);
        Customers::create([
            'name'=>request('name'),
            'email'=>request('email'),
            'mobilenumber'=>request('mobilenumber'),
            'password'=>bcrypt(request('password')),
        ]);
        return back()->with('success','New Customer Created Successfully');
    }
    public function view(){
        $datas = Customers::all();
        return view('admin.customers.view-customers',compact('datas'));
    }

    public function editCustomer($id){
        $datas = Customers::findOrfail($id);
        return view('admin.customers.edit-customer',compact('datas'));
    }

  public function updateCustomer($id,Request $request){
        $staff = Customers::findOrfail($id);
        $staff->name = request('name');
        $staff->email = request('email');
        $staff->mobilenumber = request('mobilenumber');
        $staff->save();
        return back()->with('success','Customer  Updated Successfully');
    }

    public function deleteCustomer($id){
         $Request = Customers::findOrfail($id);
           $Request->delete();
            return back()->with('success','Customer  Deleted Successfully');
    }

}
