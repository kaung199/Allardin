@extends('layouts.adminindex')

@section('contents')
<form class="d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('ddadminsearch') }}" method="GET">
    @csrf
    <div class="input-group">
        <label for="from" class="label">D-From</label>
        <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="ddfrom" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
        <label for="to" class="label">D-To</label>
        <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="ddto" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit" value="search">
            <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form> 
<hr>
@if($count)
<h4 class="badge badge-success">{{ $count }} Resusts</h4>
@endif
<div class="row">
    @foreach($orders as $order)
        <div class="col-md-4 pt-2">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <table class="table-bordered">
                        <tr>
                            <th>DeliveryDate</th>
                            <td>{{ $order->deliverydate }}</td>
                        </tr>
                        <tr>
                            <th>Order_id</th>
                            <td>{{ $order->order_id }}</td>
                        </tr>
                        <tr>
                            <th>CustomerName</th>
                            <td>{{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $order->user->phone }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="maxtd"><strong>Address: </strong>{{ $order->user->address }}</td>
                        </tr>
                        <tr>
                            <th>Delivery Name</th>
                            <td>{{ $order->dname }}</td>
                        </tr>
                    </table>
                    <div class="bt-2" style="padding-top:5px;">
                        @if($order->deliverystatus == 1)
                        <button class="btn btn-success" disabled>Order Pepare</button>
                        @endif
                        @if($order->deliverystatus == 2)                       
                        <button class="btn btn-secondary" disabled>Delivery</button>
                        @endif
                        @if($order->deliverystatus == 3)
                        <button class="btn btn-info" disabled>Payment</button>
                        @endif
                        @if($order->deliverystatus == 4)
                        <button class="btn btn-success" disabled>Complete</button>
                        @endif
                        
                        @if(Auth::user()->role_id == 3)
                        <a href="{{ route('orderdetaild', $order->id) }}" class="btn btn-primary">Detail</a>
                        @else
                            <a href="{{ route('adminorderdetail', $order->id) }}" class="btn btn-primary">Detail</a>
                        @endif
                    </div>
                    
                </div>
                
            </div>
        </div>
    @endforeach
</div>

@endsection
