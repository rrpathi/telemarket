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
      <form data-toggle="validator" id="#" class="padd-20" method="post" action="{{ route('staff.export-data') }}" enctype="multipart/form-data">
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
                     <select class="form-control" id = "exportCustomer"  name="customer_id" required="">
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
                     <label class="control-label"><span class="asterisk">Customer Count</span></label>
                     <input type="number" class="form-control" name="customer_count" min="0"  id="CustomerCount"  required="" >
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label for="inputphone" class="control-label"><span class="asterisk">Location</span></label>
                     <select class="form-control category_change" id ="location" name="location" required="">
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
                        <option value="{{ $location }}"> {{ ucfirst($location) }}</option>
                        @endforeach
                     </select>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
                 <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Database Type</span></label>
                     <select class="form-control category_change" name="database_type" id="database_type" name="">
                        <option value="business">Business</option>
                        <option value="salaried">Salary</option>

                     </select>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
                 <div class="col-sm-2">
                  <div class="form-group">
                     <label for="inputphone" class="control-label"><span class="asterisk">Category</span></label>
                          <div id="optionData"></div>

                     {{-- <select class="form-control export_change"  name="#" required="">
                        <option value="" id="optionData"></option>
                     </select> --}}
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Vendor Code</span></label>
                     <select class="form-control export_change" id="vendor_code" name="vendor_code">
                        @foreach($datas as $vendorcode)
                        <option value="{{ $vendorcode->vendorid }}">{{ $vendorcode->name}}</option>
                        @endforeach
                     </select>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
             

               
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Data Count</span></label>
                     <input type="text" class="form-control text-only" name="location_count" id="location_count" value="{{ old("location_count") }}" readonly="" required="" >
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-1">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">From</span></label>
                     <input type="number"  class="form-control count_value" min="1" name="from_count" id="from_count" value="{{ old("from_count") }}"  required="" >
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-1">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">To</span></label>
                     <input type="number" class="form-control count_value" min="1" name="to_count" id="to_count" value="{{ old("to_count") }}"  required="" >
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Export Count</span></label>
                     <input type="number" class="form-control" min="0" readonly="" id="export_count" name="export_count"  required="" >
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
        <div id="showTableData"></div>
            {{-- <button id="form-button" class="btn gredient-btn">Add More</button> --}}
   </div>
</div>
@endsection

