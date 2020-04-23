@extends('layouts.adminlayout')

@section('title')
    Orders
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">{{ $delivery->name }}'s Delivered</li>
@endsection
@section('contents') 
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>{{ $delivery->name }}'s Delivered</h3>
        </div>
        <div class="col-md-6">
            <div class="folat-right" style="float: right;">
                <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchbydatedelivery') }}" method="GET">
                    @csrf
                    <div class="input-group">
                    <label for="from">D_From</label>
                    <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="from" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                    <label for="to">D_To</label>
                    <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="to" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                    <input type="hidden" value="{{ $orders[0]->delivery_id }}" name="delivery_id">
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
<?php $total = 0; ?>
<div class="shadow p-3">
    <h3 class="text-success">Completed</h3>
    <div class="table-responsive-sm">
        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Order_id</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Total Qty</th>
            <th scope="col" class="text-right">Total Price</th>
            <th scope="col">Order Date</th>
            <th scope="col">Delivery Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($completed as $c)
                <tr>
                <th scope="row">{{ $c->order_id }}</th>
                <td>{{ $c->user->name }}</td>
                <td>{{ $c->totalquantity }}</td>
                <td class="text-right">{{ $c->totalprice + $c->user->township->deliveryprice }}</td>
                <?php $total += $c->totalprice + $c->user->township->deliveryprice;  ?>
                <td>{{ $c->created_at }}</td>
                @if(Auth::user()->role_id == 1)
                <td  data-th="">
                    @if($c->deliverystatus == 1)
                    <!-- <a href="{{ route('deliverystatus', $c->id) }}" class="btn btn-outline-primary">c Prepare</a> -->
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $c->id }}">
                        Order Prepare
                        </button>
    
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $c->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Choose Delivery Man</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {{ Form::model($c, [ 
                                    'route'=> ['orderdelivery', $c->id], 
                                    'method' => 'POST',
                                ]) }}
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
                                    <!-- <a href="{{ route('deliverystatus', $c->id) }}" class="btn btn-outline-primary">Order Prepare</a> -->
                                    <button class="btn btn-success">Next</button>
                                </div>
                            {{ Form::close() }}
                            </div>
                        </div>
                        </div>
                    @endif
                    @if($c->deliverystatus == 2)
                    <a href="{{ route('deliverystatus', $c->id) }}" class="btn btn-outline-secondary">Delivery</a>
                    @endif
                    @if($c->deliverystatus == 3)
                    <a href="{{ route('deliverystatus', $c->id) }}" class="btn btn-outline-info">Payment</a>
                    @endif
                    @if($c->deliverystatus == 4)
                    <a href="{{ route('deliverystatus', $c->id) }}" class="btn btn-outline-success text-success">Complete</a>
                    @endif
                </td>
                @else
                <td>
                    @if($c->deliverystatus == 1)
                    <a href="#" class="btn btn-outline-primary">Order Prepare</a>
                    @endif
                    @if($c->deliverystatus == 2)
                    <a href="#" class="btn btn-outline-secondary">Delivery</a>
                    @endif
                    @if($c->deliverystatus == 3)
                    <a href="#" class="btn btn-outline-info">Payment</a>
                    @endif
                    @if($c->deliverystatus == 4)
                    <a class="btn btn-outline-success text-success">Complete</a>
                    @endif
                </td>
                    
                @endif
                <td>
                    {{ Form::model($c, [ 
                        'route'=> ['orders.destroy', $c->id], 
                        'method' => 'DELETE',
                        'onsubmit' => "return confirm('Are you sure you want to DELETE this ORDER?');"
                    ]) }}
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('deliveryorderdetail', $c->id) }}">Detail</a>
                                <button class="dropdown-item">Delete</button>
                            </div>
                        </div>
                        
                    {{ Form::close() }}
                </td>
                </tr>
            @endforeach
        </tbody>
        </table>
        <div class="row">
            <div class="col-md-12 bg-dark">
                <h3 class="text-center text-danger pt-2">Grand Total = {{  $total }}</h3>
            </div>
        </div>
    </div>
</div>
<br><br>
<div class="shadow p-3">
    <h3>Delivery</h3>
    <div class="table-responsive-sm">
        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Order_id</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Total Qty</th>
            <th scope="col" class="text-right">Total Price</th>
            <th scope="col">Order Date</th>
            <th scope="col">Delivery Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_d = 0;
            @endphp
            @foreach($orders as $order)
                <tr>
                <th scope="row">{{ $order->order_id }}</th>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->totalquantity }}</td>
                <td class="text-right">{{ $order->totalprice + $order->user->township->deliveryprice }}</td>
                <?php $total_d += $order->totalprice + $order->user->township->deliveryprice;  ?>
                <td>{{ $order->created_at }}</td>
                @if(Auth::user()->role_id == 1)
                <td  data-th="">
                    @if($order->deliverystatus == 1)
                    <!-- <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-primary">Order Prepare</a> -->
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
                            {{ Form::model($order, [ 
                                    'route'=> ['orderdelivery', $order->id], 
                                    'method' => 'POST',
                                ]) }}
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
                    <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-success text-success">Complete</a>
                    @endif
                </td>
                @else
                <td>
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
                    <a class="btn btn-outline-success text-success">Complete</a>
                    @endif
                </td>
                    
                @endif
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
                                <a class="dropdown-item" href="{{ route('deliveryorderdetail', $order->id) }}">Detail</a>
                                <button class="dropdown-item">Delete</button>
                            </div>
                        </div>
                        
                    {{ Form::close() }}
                </td>
                </tr>
            @endforeach
        </tbody>
        </table>
        <div class="row">
            <div class="col-md-12 bg-dark">
                        <h3 class="text-center text-danger pt-2">Grand Total = {{  $total_d }}</h3>
            </div>
        </div>
    </div>
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
    @if(session('idNull'))
        <script>
            Swal.fire({
                title: '<div style="color:red;">No Data Found!</div>',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        </script>
    
    @endif
@endsection
