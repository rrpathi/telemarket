@extends('admin.layout.master')

@section('vendorcode')
    active
@endsection

@section('content')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Add Vendor Code</h4>
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
          <form data-toggle="validator" id="add_vendor_form" class="padd-20" method="post" action="{{ url('/admin/vendorcode/add') }}" enctype="multipart/form-data">
             <div class="card">
                {{ csrf_field() }}
                <div class="row page-titles">
                   <div class="align-center">
                      <h4 class="theme-cl">Vendor Code</h4>
                   </div>
                </div>
                  <div class="row mrg-0">
                   <div class="col-sm-4">
                      <div class="form-group">
                         <label class="control-label"><span class="asterisk">Name</span></label>
                         <input type="tel" id="name" name="name" class="form-control phone" onkeypress="return isNumberKey(event)" value="{{ old('name') }}" maxlength="15"/>
                         <div class="help-block with-errors"></div>
                      </div>
                   </div>
                <div class="col-12">
                   <div class="form-group">
                      <div class="text-center">
                         <button id="form-button" class="btn gredient-btn">Add Vendor Code</button>
                      </div>
                   </div>
                </div>
             </div>
          </form>
       </div>
</div>   
@endsection
