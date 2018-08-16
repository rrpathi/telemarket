@extends('admin.layout.master')

@section('staff')
    active
@endsection

@section('content')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-6 align-self-center">
            <h4 class="theme-cl">View Staff</h4>
        </div>
        <div class="col-md-6 align-self-center">
            <div class="text-center pull-right">
                <a href="{{ url()->previous() }}" ><button type="button" class="btn gredient-btn">Back </button></a>
            </div>
        </div>
    </div>
    @include('admin.layout.errors')
    <!-- form -->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form data-toggle="validator" class="padd-20" method="post" action="{{ route('admin.update_staff',$viewstaff->id) }}" enctype="multipart/form-data">
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
                                <label class="control-label">Name</label>
                                <input type="text" class="form-control" readonly="" name="name" onkeypress="return onlyAlphabets(event,this)" value="{{$viewstaff->name}}"  required="" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputphone" class="control-label">Email</label>
                                <input type="email" readonly="" value="{{$viewstaff->email}}"   class="form-control" name="email" id="inputphone" required="" readonly="" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mobile Number</label>
                                <input type="tel" readonly="" name="mobilenumber" class="form-control" onkeypress="return isNumberKey(event)" value="{{$viewstaff->mobilenumber}}"  maxlength="10" readonly="" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputName" class="control-label">Profile Picture</label>
                                <img src="{{$viewstaff->profilepicture}}" height="50px" width="50px">
                            </div>
                        </div>
                    </div> --}}
               {{--      <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Person Name 1</label>
                                <input type="text" readonly="" name="contactpersonname1" class="form-control" onkeypress="return onlyAlphabets(event,this);" value="{{$viewstaff->contactpersonname1}}"  required="">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Person Mobile Number 1</label>
                                <input type="tel" readonly=""  name="contactpersonmobileno1" class="form-control"  onkeypress="return isNumberKey(event)"  value="{{$viewstaff->contactpersonmobileno1}}"  maxlength="15"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Person Name 2</label>
                                <input type="text" readonly="" name="contactpersonname2" class="form-control" onkeypress="return onlyAlphabets(event,this);" value="{{ $viewstaff->contactpersonname2 }}" required="">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Person Mobile Number 2</label>
                                <input type="tel" readonly="" name="contactpersonmobileno2" value="{{ $viewstaff->contactpersonmobileno2 }}"  class="form-control"  onkeypress="return isNumberKey(event)" maxlength="15"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
