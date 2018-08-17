@extends('admin.layout.master')

@section('staff')
    active
@endsection

@section('content')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Add Staff</h4>
        </div>
    </div>
    @include('admin.layout.errors')
    <!-- form -->
    <style>                    
    .asterisk:after{
        content:"*" ;
        color:red ;
    </style>
<div class="row">
       <div class="col-md-12 col-sm-12">
          <form data-toggle="validator" id="add_vendor_form" class="padd-20" method="post" action="{{ url('/admin/staff/add') }}" enctype="multipart/form-data">
             <div class="card">
                {{ csrf_field() }}
                <div class="row page-titles">
                   <div class="align-center">
                      <h4 class="theme-cl">Personal Information</h4>
                   </div>
                </div>
                <div class="row mrg-0">
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label class="control-label"><span class="asterisk">Name</span></label>
                         <input type="text" class="form-control text-only" name="name"  value="{{ old("name") }}"  required="" >
                         <div class="help-block with-errors"></div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label for="inputphone" class="control-label"><span class="asterisk">Email</span></label>
                         <input type="email" class="form-control" name="email" id="inputphone" required="" >
                         <div class="help-block with-errors"></div>
                      </div>
                   </div>
                </div>
                <div class="row mrg-0">
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label class="control-label"><span class="asterisk">Mobile Number</span></label>
                         <input type="tel" id="mobilenumber" name="mobilenumber" class="form-control phone" onkeypress="return isNumberKey(event)" value="{{ old('mobilenumber') }}" maxlength="15"/>
                         <div class="help-block with-errors"></div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label class="control-label"><span class="asterisk"> Password</span></label>
                         <input type="password" name="password" class="form-control" required="">
                         <div class="help-block with-errors"></div>
                      </div>
                   </div>
                </div>
                <div class="col-12">
                   <div class="form-group">
                      <div class="text-center">
                         <button id="form-button" class="btn gredient-btn">Add Staff</button>
                      </div>
                   </div>
                </div>
             </div>
          </form>
       </div>
</div>   
@endsection
