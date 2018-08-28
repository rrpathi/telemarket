<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlockList;

class BlockListController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function blockindex(){
    	return view('admin.blocklist.add_number');
    }
    public  function blocklist(Request $request){
       // dd(request()->all());
        $this->validate(request(),[
            'phone_number'=>'required'
        ]);
        BlockList::create([
            'phone_number'=>request('phone_number')         
        ]);
        return back()->with('success','New BlockList Created Successfully');
    }

}
