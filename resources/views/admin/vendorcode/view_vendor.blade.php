
@extends('admin.layout.master')

@section('vendorcode')
    active
@endsection

@section('content')
@include('admin.layout.errors')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Vendors</h4>
        </div>
    </div>


    <!-- Table Card -->

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
                        <form action="{{ route('admin.destory_vendor', $data->id) }}" method="POST">
                           {{ csrf_field() }}
                           <input type="hidden" name="_method" value="DELETE">
                           <a href="{{route('admin.edit_vendor',$data->id)}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
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
