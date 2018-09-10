@extends('staff.layout.master')
@section('customer')
    active
@endsection

@section('content')
@include('staff.layout.errors')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Customers</h4>
        </div>
    </div>

     <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data->name }}</td>
                    <td>
	                   	<a href="{{route('staff.edit_customer',$data->id)}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
	                </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection