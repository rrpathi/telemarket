<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlockList;

class blockListControllers extends Controller
{
	// BLOCK LIST FORM
    public function addBlockListForm(Request $request){
    	return view('admin.blockList.add_blockList');
    }

    // ADDING BLOCK LIST
    public function addBlockList(Request $request){
    	// return $request->all();
    	$this->validate(request(),[
            'phone_number'=>'required',
        ]);
        BlockList::create(['phone_number'=>request('phone_number')]);
        return back()->with('success','Block List Added Successfully');
    }

    public function viewBlockList(Request $request){
    	 $datas = BlockList::all();
        return view('admin.blockList.view_blockList',compact('datas'));
    }

    public function editBlockList(Request $request,$id){
    	$datas = BlockList::findOrfail($id);
        return view('admin.blockList.edit_blockList',compact('datas'));
    }

     public function updateBlockList($id,Request $request){
        $blockList = BlockList::findOrfail($id);
        $blockList->phone_number = request('phone_number');
        $blockList->save();
        return back()->with('success','Block List Updated Successfully');
    }

    public function deleteBlockList(Request $request,$id){
    	$Request = BlockList::findOrfail($id);
        $Request->delete();
        return back()->with('success','Block List Deleted Successfully');
    }
}
