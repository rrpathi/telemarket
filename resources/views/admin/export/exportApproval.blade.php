@extends('admin.layout.master')

@section('approval')
	active
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Export Data Approval</h4>
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
      <form data-toggle="validator" id="#" class="padd-20" method="post" action="{{ route('admin.update_approval_status') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
         <div class="card">
            <div class="row page-titles">
               <div class="align-center">
                  <h4 class="theme-cl">Export Approval</h4>
               </div>
            </div>
            <div class="row mrg-0">
                <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Customer Name</span></label>
                     <select class="form-control" id="exportApproval" name="customer_id" required="" >
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
				    <div class="radio">
				      <label><input type="radio" value="1" id="adminApproved" name="approvedStatus" required="">Approved</label>
				    </div>
				    <div class="radio disabled">
				      <label><input type="radio" value="2" id="adminDisapproved" name="approvedStatus">Dis Approved</label>
				    </div>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
                <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label"><span class="asterisk">Export Message</span></label>
                     <textarea rows="2" cols="50" name="discription" id="CustomerDisctiption" required=""></textarea>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>
            </div>

            <div class="col-12">
               <div class="form-group">
                  <div class="text-center">
                     <button id="form-button" class="btn gredient-btn">Update Status</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
        <div id="ApprovalData"></div>
            {{-- <button id="form-button" class="btn gredient-btn">Add More</button> --}}
   </div>
</div>

@endsection


