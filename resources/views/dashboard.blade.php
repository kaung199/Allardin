@extends('layouts.adminlayout')

@section('title')
    Dashboard 
@endsection
@section('contents') 
       <!-- Icon Cards-->
       <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">Order Today</div>
                <div>Total = {{ $countallorderd }}</div>
                <table class="table table-bordered text-white">
                        <tbody>
                            <tr>
                            <th>Order Prepare</th>
                            <td>{{ $countorderso }}</td>
                            </tr>
                            <tr>
                            <th>Delivery</th>
                            <td>{{ $countordersd }}</td>
                            </tr>
                            <tr>
                            <th>Payment</th>
                            <td>{{ $countordersp }}</td>
                            </tr>
                            <tr>
                            <th>Complete</th>
                            <td>{{ $countordersc }} </td>
                            </tr>
                        </tbody>
                    </table>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ route('daily') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Order Monthly</div>
                <div>Total = {{ $countallorderm }}</div>
                <table class="table table-bordered text-white">
                        <tbody>
                            <tr>
                            <th>Order Prepare</th>
                            <td>{{ $countordersmo }}</td>
                            </tr>
                            <tr>
                            <th>Delivery</th>
                            <td>{{ $countordersmd }}</td>
                            </tr>
                            <tr>
                            <th>Payment</th>
                            <td>{{ $countordersmp }}</td>
                            </tr>
                            <tr>
                            <th>Complete</th>
                            <td>{{ $countordersmc }} </td>
                            </tr>
                        </tbody>
                    </table>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ route('monthly') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">Order Yearly!</div>
                <div>Total = {{ $countallordery }}</div>
                <table class="table table-bordered text-white">
                        <tbody>
                            <tr>
                            <th>Order Prepare</th>
                            <td>{{ $countordersyo }}</td>
                            </tr>
                            <tr>
                            <th>Delivery</th>
                            <td>{{ $countordersyd }}</td>
                            </tr>
                            <tr>
                            <th>Payment</th>
                            <td>{{ $countordersyp }}</td>
                            </tr>
                            <tr>
                            <th>Complete</th>
                            <td style="max-width: 100px;">{{ $countordersyc }} </td>
                            </tr>
                        </tbody>
                    </table>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ route('yearly') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">Total User!</div>
                <h4 class="text-center" style="padding-top: 98px;">{{ $countusers }}</h4>
                    
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ route('customers') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>

@endsection
