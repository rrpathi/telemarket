<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Admin;
use App\Password;
use Auth;
use Hash;
use App\Http\Requests;
use App\Helpers\Helper;

class AdminStaffController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function index(){
        $datas = Staff::all();
        return view('admin.staff.add_staff', compact('datas'));
    }
    public  function  store(Request $request){
        $this->validate(request(),[
            'name'=>'required',
            'email'=>'required|unique:staff',
            'mobilenumber'=>'required',
            'password'=>'required',
        ]);
        Staff::create([
            'name'=>request('name'),
            'email'=>request('email'),
            'mobilenumber'=>request('mobilenumber'),
            'password'=>bcrypt(request('password')),
        ]);
        return back()->with('success','New staff Created Successfully');
    }
    // public function delete($id){
    //    try{
    //        $Request = Staff::findOrfail($id);
    //        $Request->delete();
    //        return back();
    //    } catch (Exception $e){
    //        return back();
    //    }
    // }

      
    public function Staffindex(){
        $datas = Staff::all();
        return view('admin.staff.index', compact('datas'));
    }

    public function view($id){
       $viewstaff = Staff::find($id);
       return view('admin.staff.view_staff',compact('viewstaff'));
    }
    public function deletestaff($id){
         $Request = Staff::findOrfail($id);
           $Request->delete();
            return back()->with('success','staff  Deleted Successfully');
    }
    public function showEditstaff($id){
        $editstaff = Staff::find($id);
        $staff_type = Staff::all();
        return view('admin.staff.edit_staff',compact('editstaff','staff'));
    }
    public function updatestaff($id,Request $request){
        $staff = Staff::findOrfail($id);
        $staff->name = request('name');
        $staff->email = request('email');
        $staff->mobilenumber = request('mobilenumber');
        $staff->save();
        return back()->with('success','staff  Updated Successfully');
    }
//      public  function account(){
    
//       $datas = auth()->user();
//       return view('admin.account',compact('datas'));
// }
   
//      public function updateaccount($id,Request $request){
//        $image = $request->file('profilepicture');
//         Admin::where('id',$id)->update([
//             'name'=>request('name'),
//             'email'=>request('email'),
//             'profilepicture'=>Helper::upload_picture($image),
//             ]);
//         return back()->with('success','Account Updated Successfully');
//     }
//      public  function password(){
    
//       $datas = auth()->user();
//       return view('admin.password',compact('datas'));
// }
//     public function updatepassword(){
//     $oldpassword = request('oldpassword');
//     $newpassword = request('newpassword');
//     $confirmpassword = request('confirmpassword');
//     $admin = Admin::findOrfail(Auth::user()->id);
//     if($newpassword === $confirmpassword){
//          if(Hash::check($oldpassword,$admin->password)){
//           $admin->password = bcrypt($newpassword);
//           $admin->save();
//                 return back()->with('success','Password Changed Successfully');
//            }else{
//                return back()->with('danger','Enter Correct Old Password');
//            }
//        }else{
//            return back()->with('danger','Password Does Not Match');
//        }
       
//    }

   public function blockedstaff(){
        $datas = Staff::where('verified','2')->get();
        return view('admin.staff.blocked_staff',compact('datas'));
   }

   public function unblockedstaff($id){
    if(request()->server('HTTP_REFERER')){
        Staff::where('id',$id)->update([
          'verified' => 1,
        ]);
        return back()->with('success','staff UnBlocked Successfully');
          }else{
            return back();
            }

   }

   public function contact(){
    return view('admin.contacts.add_contact');
   }

  
}
