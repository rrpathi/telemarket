@extends('staff.layout.master')

@section('export')
	active
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Export Data</h4>
        </div>
    </div>
    @include('staff.layout.errors')
    <style>                    
    .asterisk:after{
        content:"*" ;
        color:red ;
        </style>
    <!-- form -->
<div class="row">
   <div class="col-md-12 col-sm-12">
      <form data-toggle="validator" id="#" class="padd-20" method="post" action="{{ route('staff.export-data-staff') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
         <div class="card">
            <div class="row page-titles">
               <div class="align-center">
                  <h4 class="theme-cl">Customer Details</h4>
               </div>
            </div>
            <div class="row mrg-0">
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Customer Name</span></label>
                     <select class="form-control" id = "exportCustomerData"  name="customer_id" required="">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ ucfirst($customer->name) }}</option>
                        @endforeach
                     </select>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Export Status</span></label>
                     <input type="text" class="form-control" readonly=""  id="exportStatus"  required="" >
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
                <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Export Message</span></label>
                     <textarea rows="2" cols="50" id="CustomerDisctiption" readonly=""></textarea>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
                <div class="col-12">
               <div class="form-group">
                  <div class="text-center">
                     <button id="exportButtonStaff" class="btn gredient-btn" disabled>Export Data</button>
                  </div>
               </div>
            </div>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection


