
@extends('admin.layout.master')

@section('staff')
    active
@endsection

@section('content')
@include('admin.layout.errors')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Staffs</h4>
        </div>
    </div>


    <!-- Table Card -->

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->mobilenumber }}</td>
                    <td>
                        <form action="{{ route('admin.destory_staff', $data->id) }}" method="POST">
                           {{ csrf_field() }}
                           <input type="hidden" name="_method" value="DELETE">
                           <a href="{{route('admin.edit_staff',$data->id)}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                         {{--   <a href="{{route('admin.block_staff',$data->id)}}" class="btn btn-warning"><i class="fa fa-ban"></i></a> --}}
                           <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> </button>
                       </form>
                </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>




@endsection
