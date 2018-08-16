@extends('admin.layout.master')
@section('staff')
   active
@endsection
@section('content')
   <!-- Title & Breadcrumbs-->
   <div class="row page-titles">
       <div class="col-md-12 align-self-center">
           <h4 class="theme-cl">Blocked Staff List</h4>
       </div>
   </div>    
   @include('admin.layout.errors')    
   <!-- Table Card -->
   <div class="card">
       <div class="table-responsive">
           <table class="table table-striped table-2 table-hover">
               <thead>
                   <tr>
                       <th>Name</th>
                       <th>Email</th>
                       <th>Mobile Number</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody>
               @foreach($datas as $data)
                   <tr>
                       <td>{{ $data->name }}</td>
                       <td>{{ $data->email }}</td>
                       <td>{{ $data->mobilenumber }}</td>
                       <td>
                        <!-- onclick="return confirm('Are you sure?')" -->
                           <a href="#" class="label label-info"  onclick="event.preventDefault(); 
                           if(confirm('Are You Sure You Want To Unblock staff') ==true){
                            document.getElementById('unblock-staff-{{$data->id}}').submit();}">Unblock</a>
                           <a href="{{route('admin.view_staff',$data->id)}}" class="label label-primary">View</a>                            
                           <form id="unblock-staff-{{$data->id}}" action="{{  route('admin.unblock_staff',$data->id) }}" method="POST" style="display: none;">
                               {{ csrf_field() }}
                           </form>
                       </td>
                   </tr>
               @endforeach                
               </tbody>
           </table>
       </div>
   </div>
   <!-- /.Table Card -->@endsection