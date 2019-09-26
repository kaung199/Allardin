@extends('layouts.adminlayout')

@section('title')
    Orders
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('order') }}">Order</a></li>
    <li class="breadcrumb-item active">
        Delivery
        @if($from && $to)
        ( {{ $from . '/' .  $to }} )
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
                    @if($from && $to)
                    <a class="dropdown-item" href="{{ route('orderpreparef',[$from, $to]) }}">Order Prepare</a>
                    <a class="dropdown-item" href="{{ route('deliveryf', [$from, $to]) }}">Delivery</a>
                    <a class="dropdown-item" href="{{ route('paymentf', [$from, $to]) }}">Payment</a>
                    <a class="dropdown-item" href="{{ route('completef', [$from, $to]) }}">Complete</a>
                    @else
                    <a class="dropdown-item" href="{{ route('orderprepare') }}">Order Prepare</a>
                    <a class="dropdown-item" href="{{ route('delivery') }}">Delivery</a>
                    <a class="dropdown-item" href="{{ route('payment') }}">Payment</a>
                    <a class="dropdown-item" href="{{ route('complete') }}">Complete</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
        <div class="folat-right" style="float: right;">
                <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchalld') }}" method="GET">
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
@foreach($orders as $order)
    <div class="shadow-lg p-3 mb-5 bg-white rounded">
        <div class="row">
            <div class="col-md-9">
                <h6><strong>Order_id = {{ $order->order_id }}</strong></h6>
                <h6><strong>Order_Date = {{ $order->created_at }}</strong></h6>
                @if($order->deliverydate != null)
                <h6><strong>Delivery_Date = {{ $order->deliverydate }}</strong></h6>
                @endif
                @if($order->remark != null)
                <h6><strong>Remark = {{ $order->remark }}</strong></h6>
                @endif
            </div>
            <div class="col-md-3">
                <h6><strong>
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
                                @if(Auth::user()->role_id == 4)
                                <a class="dropdown-item" href="{{ route('orderdetailp', $order->id) }}">Detail</a>
                                @else
                                <a class="dropdown-item" href="{{ route('orderdetail', $order->id) }}">Detail</a>
                                @endif
                                <button class="dropdown-item">Delete</button>
                            </div>
                        </div>
                        
                    {{ Form::close() }}
                </strong></h6>
                <h6>
                    <strong>
                        @if(Auth::user()->role_id == 1)
                            @if($order->deliverystatus == 1)
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $order->id }}">
                                Order Prepare
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Choose Delivery Man</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @if(Auth::user()->role_id ==4 )
                                    {{ Form::model($order, [ 
                                            'route'=> ['orderdeliveryp', $order->id], 
                                            'method' => 'POST',
                                        ]) }}
                                    @else
                                    {{ Form::model($order, [ 
                                            'route'=> ['orderdelivery', $order->id], 
                                            'method' => 'POST',
                                        ]) }}
                                    @endif
                                        <div class="modal-body">                        

                                            {{ Form::label(null,'Delivery Man') }}
                                            {{ Form::select('delivery_id', $deliveries, 'null', [
                                                'class' => 
                                                ($errors->has('delivery_id')? 'form-control is-invalid': 'form-control'), 
                                            ]) }}
                                            @if($errors->has('delivery_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>
                                                        {{ $errors->first('delivery_id') }}
                                                    </strong>
                                                </span>
                                            @endif
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <!-- <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-primary">Order Prepare</a> -->
                                            <button class="btn btn-success">Next</button>
                                        </div>
                                    {{ Form::close() }}
                                    </div>
                                </div>
                                </div>
                            @endif
                            @if($order->deliverystatus == 2)
                            <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-secondary">Delivery</a>
                            @endif
                            @if($order->deliverystatus == 3)
                            <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-info">Payment</a>
                            @endif
                            @if($order->deliverystatus == 4)
                            <a href="#" class="btn btn-outline-success">Complete</a>
                            @endif
                        @else
                                @if($order->deliverystatus == 1)
                                <a href="#" class="btn btn-outline-primary">Order Prepare</a>
                                @endif
                                @if($order->deliverystatus == 2)
                                <a href="#" class="btn btn-outline-secondary">Delivery</a>
                                @endif
                                @if($order->deliverystatus == 3)
                                <a href="#" class="btn btn-outline-info">Payment</a>
                                @endif
                                @if($order->deliverystatus == 4)
                                <a href="#" class="btn btn-outline-success">Complete</a>
                                @endif
                        @endif 

                    </strong>
                </h6>
            </div>                
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col">Products</th>
                    <th scope="col" class="text-right">Quantity</th>
                    <th scope="col" class="text-right">Price</th>
                    <th scope="col" class="text-right">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderdetails as $orderdetail)
                        <tr>
                            <td>{{ $orderdetail->name }}</td>
                            <td class="text-right">{{ $orderdetail->quantity }}</td>
                            <td class="text-right">{{ $orderdetail->price }}</td>
                            <td class="text-right">{{ $orderdetail->totalprice }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-center">Delivery Price</th>
                        <th class="text-right">{{ $orderdetail->user->township->deliveryprice }}</th>
                    </tr>
                    @if($order->discount != null)
                    <tr>
                        <th colspan="3" class="text-center text-danger">Discount Price</th>
                        <th class="text-right text-danger">-{{ $order->discount }}</th>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="text-center">Total</th>
                        <th class="text-right"> {{ $order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <h4>Customer Information</h4>
        <table class="table table-bordered table-dark ">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->phone }}</td>
                <td>{{ $order->user->address }}</td>
            
            </tr>
            </tbody>
        </table>
    </div>
@endforeach
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
