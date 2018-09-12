@extends('admin.layout.master')

@section('dashboard')
    active
@endsection

@section('content')
    <!-- Title & Breadcrumbs-->
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
            <h4 class="theme-cl">Dashboard</h4>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->

    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                       <i class="icon  gredient-cl font-30">{{$totalStaffs}}</i>
                    </div>
                    <div class="widget-detail">
                        <h4 class="mb-1"></h4>
                        <span>Total Staffs </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="icon gredient-cl font-30">{{$totalCustomers}}</i>
                    </div>
                    <div class="widget-detail">
                        <h4 class="mb-1"></h4>
                        <span>Total Customers</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="icon ti-layout-grid2 gredient-cl font-30"></i>
                    </div>
                    <div class="widget-detail">
                        <h4 class="mb-1">{{ $data['total_vendor'] }}</h4>
                        <span>Total Vendors</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="icon ti-user gredient-cl font-30"></i>
                    </div>
                    <div class="widget-detail">
                        <h4 class="mb-1"></h4>
                        <span>Total Users</span>
                    </div>
                </div>
            </div>
        </div> --}}
@endsection
