@extends('admin.layout.master')

@section('database')
    active
@endsection

@section('content')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Add Database</h4>
        </div>
    </div>
    @include('admin.layout.errors')
    <!-- form -->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form data-toggle="validator" id="add_vendor_form" class="padd-20" method="post" action="{{ url('/admin/database/add') }}" enctype="multipart/form-data">
                <div class="card">
                    {{ csrf_field() }}
                    <div class="row page-titles">
                        <div class="align-center">
                            <h4 class="theme-cl">File Upload</h4>
                        </div>
                     </div>
    
                    <div class="row mrg-0"> 
                        <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form-control" name="vendor_code">
                        @foreach($datas as $vendorcode)
                            <option value="{{ $vendorcode->vendorid }}">{{ $vendorcode->name}}</option>
                        @endforeach
                          
                        </select>   
                      
                      <div class="help-block with-errors"></div>
                    </div>
                </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="file" name="file" class="form-control-file"  aria-describedby="fileHelp">
                            </div>
                        </div>

                    </div>
                 
                    </div>
                </div>
                    </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="text-center">
                                <button id="form-button" class="btn gredient-btn">Add Database</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
