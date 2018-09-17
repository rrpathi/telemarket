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
    </div>
    <div class="row page-titles">
        <div class="col-md-12 align-self-center">
             <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Location</th>
                  <th scope="col">Salary</th>
                  <th scope="col">Business</th>
                </tr>
              </thead>
              <tbody>
                @foreach($PlaceDataCount as  $key => $placeCount)
                    <tr>
                      <td> {{$key}}</td>
                      <td>{{$placeCount['salaried']}}</td>
                      <td>{{$placeCount['business']}}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>  
    </div>
       
@endsection
