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
  <style>                    
    .asterisk:after{

        content:"*" ;

        color:red ;
        </style>

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
                       {{--  <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputName" class="control-label"><span class="asterisk">Profile Picture</span></label>
                                <input type="file" name="profilepicture" class="form-control-file" id="inputName" aria-describedby="fileHelp" multiple>
                            </div>
                        </div>
                    </div> --}}
                  {{--   <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><span class="asterisk">Contact Person Name 1</span></label>
                                <input type="text" name="contactpersonname1" class="form-control text-only" required="">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><span class="asterisk">Contact Person Mobile Number 1</span></label>

                                <input type="tel" name="contactpersonmobileno1" id="contactpersonmobileno1" class="form-control phone"  onkeypress="return isNumberKey(event)" value="{{ old('contactpersonmobileno1') }}" maxlength="15"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Person Name 2</label>
                                <input type="text" name="contactpersonname2" class="form-control text-only" value="{{ old('contactpersonname1') }}" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Person Mobile Number 2</label>
                                <input type="tel" name="contactpersonmobileno2" id="contactpersonmobileno2" class="form-control phone" onkeypress="return isNumberKey(event)" value="{{ old('contactpersonmobileno2') }}" maxlength="15" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
 --}}
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><span class="asterisk"> Password</span></label>
                                <input type="password" name="password" class="form-control" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>
                    </div>
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
@section('script')
    <script type="text/javascript">
        var expanded = false;
        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
    <script>

        $('#form-button').click(function () {
            var number = $("#mobilenumber").intlTelInput("getNumber");
            $("#mobilenumber").val(number);
            var number = $("#contactpersonmobileno1").intlTelInput("getNumber");
            $("#contactpersonmobileno1").val(number);
            var number = $("#contactpersonmobileno2").intlTelInput("getNumber");
            $("#contactpersonmobileno2").val(number);
            $('#add_staff_form').submit();
        });

    </script>
<script type="text/javascript" src="{{ url('js/state.js') }}"></script>
<script type="text/javascript" src="{{ url('js/jquery.js') }}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


@endsection

@section('style')
    <style type="text/css">



        .selectBox {
            position: relative;
        }

        .selectBox select {
            width: 100%;
            font-weight: bold;
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            display: none;
            border: 1px #e9eff4 solid;
        }

        #checkboxes label {
            display: block;
            margin-left: 8px;
            margin-top: 8px;
        }

        #checkboxes label:hover {
            background-color: #de67b4;
        }
    </style>
@endsection
