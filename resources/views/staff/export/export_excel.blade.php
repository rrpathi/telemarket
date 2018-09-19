@extends('staff.layout.master')

@section('export')
	active
@endsection

@section('content')
 <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Export Excel</h4>
        </div>
    </div>
     @include('staff.layout.errors')
    <style>                    
    .asterisk:after{
        content:"*" ;
        color:red ;
        </style>
    <!-- Table Card -->

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Customer customer_count</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($datas as $data)
                <tr>
                    <td>{{$data->customer->name}}</td>
                    <td>{{$data->customer_count}}</td>
                    <td>
                     <a href="{{route('staff.DownloadExcel',$data->id)}}" class="btn btn-info"><i class="fa fa-download"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


