
@extends('admin.layout.master')

@section('export')
    active
@endsection

@section('content')
@include('admin.layout.errors')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Export Excel</h4>
        </div>
    </div>
    <!-- Table Card -->

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Customer customer_count</th>
                    <th>Staff</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{$data->customer->name}}</td>
                    <td>{{$data->customer_count}}</td>
                    <td>
                        @if($data->staffIds==0)
                        Admin
                        @else
                            {{$data->staff->name}}
                        @endif
                    </td>
                    <td>
                     <a href="{{route('admin.DownloadExcel',$data->id)}}" class="btn btn-info"><i class="fa fa-download"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
