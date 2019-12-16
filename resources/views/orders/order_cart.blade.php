@extends('layouts.adminlayout')

@section('title')
    Orders
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Order_cart</li>
@endsection
@section('contents') 
<h3>Order_cart <span class="text-danger">( {{ $count }} )</span></h3>
<br>
@foreach($orders as $order)
<?php $total = 0;?>
    <div class="shadow-lg p-3 mb-5 bg-white rounded">
        <div class="row">
            <div class="col-md-9">
                <h6><strong>Order_Date = {{ $order->created_at }}</strong></h6>
                <h6><strong>Delivery_Date = {{ $order->delivery_date }}</strong></h6>
                @if($order->remark != null)
                <h6><strong>Remark = {{ $order->remark }}</strong></h6>
                @endif
            </div>  
            <div class="col-md-3">
                <h6><strong>
                    {{ Form::model($order, [ 
                        'route'=> ['order_cart_delete', $order->id], 
                        'method' => 'DELETE',
                        'onsubmit' => "return confirm('Are you sure you want to DELETE this ORDER?');"
                    ]) }}
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('orders.order_cart_editp', $order->id) }}">Edit Product</a>
                                <a class="dropdown-item" href="{{ route('orders.order_cart_edit', $order->id) }}">Edit Info</a>
                                <button class="dropdown-item">Delete</button>
                            </div>
                        </div>
                        
                    {{ Form::close() }}
                </strong></h6>
                <a class="btn btn-success" href="{{ route('orders.order_cart_confirm', $order->id) }}">Confirm Order</a>
                
            </div>             
        </div>
        <br>
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
                    @foreach($order->cart_products as $orderdetail)
                    <?php $totalprice = $orderdetail->quantity * $orderdetail->price; ?>
                        <tr>
                            <td>{{ $orderdetail->name }}</td>
                            <td class="text-right">{{ $orderdetail->quantity }}</td>
                            <td class="text-right">{{ $orderdetail->price }}</td>
                            <td class="text-right">{{ $totalprice }}</td>
                        </tr>
                        <?php $total += $totalprice; ?>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-center">Delivery Price</th>
                        <th class="text-right">{{  $order->township->deliveryprice }}</th>
                    </tr>
                    @if($order->discount != null)
                    <tr>
                        <th colspan="3" class="text-center text-danger">Discount Price</th>
                        <th class="text-right text-danger">-{{ $order->discount }}</th>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="text-center">Total</th>
                        <th class="text-right"> {{ $total += $order->township->deliveryprice - $order->discount }}</th>
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
                <td>{{ $order->name }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->address }}</td>
            
            </tr>
            </tbody>
        </table>
    </div>
@endforeach
<div class="text-center">{{ $orders->links() }}</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    <script>
        @if(session('deleted'))        
                Swal.fire({
                    title: 'Order_cart Deleted Successfuly',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })      
        @endif
    </script>

@endsection
