@extends('staff.layout.master')

@section('customer')
active
@endsection

@section('content')
  <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Add Customer</h4>
        </div>
    </div>
     @include('staff.layout.errors')
	<style>                    
	    .asterisk:after{
	        content:"*" ;
	        color:red ;
	</style>

	<div class="row">
	   <div class="col-md-12 col-sm-12">
	      <form data-toggle="validator" id="#" class="padd-20" method="post" action="{{ route('staff.add_customer') }}" enctype="multipart/form-data">
	         <div class="card">
	            {{ csrf_field() }}
	            <div class="row page-titles">
	               <div class="align-center">
	                  <h4 class="theme-cl">Personal Details</h4>
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
	            </div>
	            <div class="col-12">
	            <div class="form-group">
	               <div class="text-center">
	                  <button id="form-button" class="btn gredient-btn">Add Customer</button>
	               </div>
	            </div>
	         </div>
	         </div>
	         
	      </form>
	   </div>
	</div>
@endsection