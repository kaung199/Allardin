@extends('layouts.adminlayout')

@section('title')
    Orders
@endsection
@section('breadcrumbs')
    @if($today)
    <li class="breadcrumb-item active"><a href="{{ route('daily') }}">DailyOrder</a></li>
    @endif
    @if($thismonth)
    <li class="breadcrumb-item active"><a href="{{ route('monthly') }}">MonthlyOrder</a></li>
    @endif
    @if($thisyear)
    <li class="breadcrumb-item active"><a href="{{ route('yearly') }}">YearlyOrder</a></li>
    @endif
    <li class="breadcrumb-item active">
        Payment
        @if($from && $to)
        ( {{ $from . '/' .  $to }} )
        @else
        Today
        @endif
    </li>
@endsection
@section('contents') 
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter with Delivery Status
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @if($today)
                    @if($from && $to)
                        <a class="dropdown-item" href="{{ route('orderpreparedf', [$from, $to]) }}">Order Prepare</a>
                        <a class="dropdown-item" href="{{ route('deliverydf', [$from, $to]) }}">Delivery</a>
                        <a class="dropdown-item" href="{{ route('paymentdf', [$from, $to]) }}">Payment</a>
                        <a class="dropdown-item" href="{{ route('completedf', [$from, $to]) }}">Complete</a>
                        @else
                        <a class="dropdown-item" href="{{ route('orderprepared') }}">Order Prepare</a>
                        <a class="dropdown-item" href="{{ route('deliveryd') }}">Delivery</a>
                        <a class="dropdown-item" href="{{ route('paymentd') }}">Payment</a>
                        <a class="dropdown-item" href="{{ route('completed') }}">Complete</a>
                        @endif
                    @endif
                    @if($thismonth)
                        <a class="dropdown-item" href="{{ route('orderpreparem') }}">Order Prepare</a>
                        <a class="dropdown-item" href="{{ route('deliverym') }}">Delivery</a>
                        <a class="dropdown-item" href="{{ route('paymentm') }}">Payment</a>
                        <a class="dropdown-item" href="{{ route('completem') }}">Complete</a>
                    @endif
                    @if($thisyear)
                        <a class="dropdown-item" href="{{ route('orderpreparey') }}">Order Prepare</a>
                        <a class="dropdown-item" href="{{ route('deliveryy') }}">Delivery</a>
                        <a class="dropdown-item" href="{{ route('paymenty') }}">Payment</a>
                        <a class="dropdown-item" href="{{ route('completey') }}">Complete</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if($today)
                <div class="folat-right" style="float: right;">
                    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchbydatep') }}" method="GET">
                        @csrf
                        <div class="input-group">
                        <label for="from">From</label>
                        <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="from" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                        <label for="to">To</label>
                        <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="to" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" value="search">
                            <i class="fas fa-search"></i>
                            </button>
                        </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
<br>
<div class="scrolldo">
    <table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">Order_id</th>
        <th scope="col">Customer Name</th>
        <th scope="col">Total Qty</th>
        <th scope="col" class="text-right">Total Price</th>
        <th scope="col">Order Date</th>
        <th scope="col">Delivery Date</th>
        <th scope="col">Remark</th>
        <th scope="col">Delivery Status</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
            <th scope="row">{{ $order->order_id }}</th>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->totalquantity }}</td>
            <td class="text-right">{{ $order->totalprice + $order->user->township->deliveryprice }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->deliverydate }}</td>
            <td>{{ $order->remark }}</td>
            <td  data-th="">
                @if($order->deliverystatus == 1)
                <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-primary">Order Prepare</a>
                @endif
                @if($order->deliverystatus == 2)
                <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-secondary">Delivery</a>
                @endif
                @if($order->deliverystatus == 3)
                <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-info">Payment</a>
                @endif
                @if($order->deliverystatus == 4)
                <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-success">Complete</a>
                @endif
            </td>
            <td>
                {{ Form::model($order, [ 
                    'route'=> ['orders.destroy', $order->id], 
                    'method' => 'DELETE',
                    'onsubmit' => "return confirm('Are you sure you want to DELETE this ORDER?');"
                ]) }}
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('orderdetail', $order->id) }}">Detail</a>
                            <button class="dropdown-item">Delete</button>
                        </div>
                    </div>
                    
                {{ Form::close() }}
            </td>
            </tr>
        @endforeach
    </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    @if(session('deliverystatus'))
        <script>
            Swal.fire({
                title: 'Delivery Status Updated Successfuly',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        </script>
    
    @endif
    @if(session('permission'))
        <script>
            Swal.fire({
                title: 'Permission Access Deny !!Ask Admin!!',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        </script>
    
    @endif
@endsection
