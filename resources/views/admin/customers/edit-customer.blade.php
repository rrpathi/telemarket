@extends('admin.layout.master')

@section('customer')
    active
@endsection

@section('content')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Update Customer</h4>
        </div>
    </div>
    @include('admin.layout.errors')
    <!-- form -->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form data-toggle="validator" class="padd-20" method="post" action="{{ route('admin.update_customer',$datas->id) }}" enctype="multipart/form-data">
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
                                <input type="text" class="form-control text-only" name="name"  value="{{$datas->name}}"  required="" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputphone" class="control-label">Email</label>
                                <input type="email" value="{{$datas->email}}"   class="form-control" name="email" id="inputphone" required="" readonly="" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mobile Number</label>
                                <input type="tel" id="mobilenumber" name="mobilenumber" class="form-control phone" onkeypress="return isNumberKey(event)" value="{{$datas->mobilenumber}}" maxlength="15" readonly/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn gredient-btn">Update staff</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
