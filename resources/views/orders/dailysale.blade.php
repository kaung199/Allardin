@extends('layouts.adminlayout')

@section('title')
    Orders Daily
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"> <a href="{{ url('order') }}">Order</a></li>
    <li class="breadcrumb-item active">DailyOrder</li>
@endsection
@section('contents') 
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Daily Orders</h3>               
        </div>
        <div class="col-md-6">
            <div class="folat-right" style="float: right;">
                <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchbydatedaily') }}" method="POST">
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
        </div>
    </div>
</div>
<br>
<table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">Product</th>
        <th scope="col">Deli_Status</th>
        <th scope="col" class="text-right">Unit Price</th>
        <th scope="col" class="text-right">Qty</th>
        <th scope="col" class="text-right">Deli_Price</th>
        <th scope="col" class="text-right">TotalPrice</th>
        <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            @foreach($order->orderdetails as $od)
            <tr>
            <td>{{ $od->name }}</td>
            <td>
                @if($order->deliverystatus == 1)
                    <p class="text-primary">OrderPrepare</p>
                @endif
                @if($order->deliverystatus == 2)
                    <p class="text-warning">Delivery</p>
                @endif
                @if($order->deliverystatus == 3)
                    <p class="text-info">Payment</p>
                @endif
                @if($order->deliverystatus == 4)
                    <p class="text-success">Complete</p>
                @endif
            </td>
            <td class="text-right">{{ $od->price }}</td>
            <td class="text-right">{{ $od->quantity }}</td>
            <td class="text-right">{{ $od->user->township->deliveryprice }}</td>
            <td class="text-right">{{ $od->quantity * $od->price + $od->user->township->deliveryprice }}</td>
            <td class="text-center"><a href="{{ route('orderdetail', $order->id) }}" class="btn btn-primary">Detail</a></td>
            </tr>
            @endforeach
        @endforeach
    <tbody>
</table>
@endsection
