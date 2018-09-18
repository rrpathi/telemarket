@extends('staff.layout.master')

@section('export')
	active
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Edit Export Data</h4>
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
      <form data-toggle="validator" id="#" class="padd-20" method="post" action="{{ route('staff.update_export_data',$export_history->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
         <div class="card">
            <div class="row page-titles">
               <div class="align-center">
                  <h4 class="theme-cl">Customer Details</h4>
               </div>
            </div>
            <div class="row mrg-0">
              {{-- {{$TempData['0']->id}} --}}

                 <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Customer Name</span></label>
                     <select class="form-control" id = "exportCustomer"  name="customer_id" required="" disabled="">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" <?php if( $customer->id==$export_history->customer_id){echo "selected";} ?>>{{ ucfirst($customer->name) }}</option>
                        @endforeach
                     </select>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Customer Count</span></label>
                     <input type="number" class="form-control" name="customer_count" min="0"  id="CustomerCount" value="{{$TempData['0']->remaining_count}}"  required="" disabled="" >
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label for="inputphone" class="control-label"><span class="asterisk">Location</span></label>
                     <select class="form-control location_change" id ="location" name="location" required="">
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
                        <option value="{{ $location }}" <?php if($location==$export_history->location){echo 'selected';} ?>> {{ ucfirst($location) }}</option>
                        @endforeach
                     </select>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
                 <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Database Type</span></label>
                        <div id="DatabaseTypeData"></div>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
                 <div class="col-sm-2">
                  <div class="form-group">
                     <label for="inputphone" class="control-label"><span class="asterisk">Category</span></label>
                          <div id="CategoryDatas"></div>

                     {{-- <select class="form-control export_change"  name="#" required="">
                        <option value="" id="optionData"></option>
                     </select> --}}
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Vendor Code</span></label>
                     <div id="VendorCodeData"></div>
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
                     <input type="number"  class="form-control count_value" min="1" value="{{$export_history->from_count}}" name="from_count" id="from_count" value="{{ old("from_count") }}"  required="" >
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-1">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">To</span></label>
                     <input type="number" class="form-control count_value" min="1" value="{{$export_history->to_count}}" name="to_count" id="to_count" value="{{ old("to_count") }}"  required="" >
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Export Count</span></label>
                     <input type="number" class="form-control" min="0" readonly="" id="export_count" value="{{$export_history->export_count}}"  name="export_count"  required="" >
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
@section('scriptOnload')
<!-- <script type="text/javascript">
  $(document).ready(function(){
    // $(window).on('load', function () {
      setTimeout(function() {
        $('.category_change').trigger('change');
          setTimeout(function() {
            $("#category option[value='<?php echo $export_history->category ?>']").attr('selected', 'selected');
            $("#vendor_code option[value='<?php echo $export_history->vendor_code ?>']").attr('selected', 'selected');
            $('.export_change').trigger('change');
          }, 3000);
            $('.export_change').trigger('change');
      }, 100);
  // });
});
</script> -->
<script type="text/javascript">
  $(document).ready(function(){
    // $( window ).on("load", function() {
      setTimeout(function() {
          $('.location_change').trigger('change');
          setTimeout(function() {
              $("#database_type option[value='<?php echo $export_history->database_type ?>']").attr('selected', 'selected');
              $('.database_type_change').trigger('change');
              setTimeout(function() {
                  $("#category option[value='<?php echo $export_history->category ?>']").attr('selected', 'selected');
                  $('.catagory_change').trigger('change');
                  setTimeout(function() {
                      $("#vendor_code option[value='<?php echo $export_history->vendor_code ?>']").attr('selected', 'selected');
                      $('.export_data_count').trigger('change');
                  }, 1000);
              }, 1000);
          }, 1000);
      }, 100);
  // });
});
</script>
@endsection

