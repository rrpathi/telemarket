@extends('admin.layout.master')

@section('export')
	active
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Export Data</h4>
        </div>
    </div>
    @include('admin.layout.errors')
    <style>                    
    .asterisk:after{
        content:"*" ;
        color:red ;
        </style>
    <!-- form -->
    <div class="row">
   <div class="col-md-12 col-sm-12">
      <form data-toggle="validator" id="#" class="padd-20" method="post" action="{{ url('/admin/customer/add') }}" enctype="multipart/form-data">
         <div class="card">
            {{ csrf_field() }}
            <div class="row page-titles">
               <div class="align-center">
                  <h4 class="theme-cl">Customer Details</h4>
               </div>
            </div>
            <div class="row mrg-0">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Customer Name</span></label>
                      <select class="form-control" id = "list_entry" name="customer_name" >
                         <option value="">Select Customer</option>
                      @foreach($customers as $customer)
                        <option value="{{ $customer->name }}">{{ ucfirst($customer->name) }}</option>
                      @endforeach
                      </select>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label for="inputphone" class="control-label"><span class="asterisk">Location</span></label>
                     <select class="form-control" id = "list_entry" name="location" >
                         <option value="">Select Location</option>
                      @foreach($locations as $location)
                        <option value="{{ $location }}"> {{ ucfirst($location) }}</option>
                      @endforeach
                      </select>                  
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
            </div>
            <div class="col-12">
            <div class="form-group">
               <div class="text-center">
                  <button id="form-button" class="btn gredient-btn">Export Data</button>
               </div>
            </div>
         </div>
         </div>
      </form>
   </div>
</div>
@endsection
