@extends('layouts.adminlayout')

@section('title')
    Cutomer's Orders
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('customers') }}">Customers</a></li>
    <li class="breadcrumb-item active">Orders</li>
@endsection
@section('contents') 
<h3>{{ $orders[0]->user->name}}'s Orders</h3>

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
    @foreach($orders as $order)
        <tr>
        <th scope="row">{{ $order->order_id }}</th>
        <td>{{ $order->user->name }}</td>
        <td>{{ $order->totalquantity }}</td>
        <td class="text-right">{{ $order->totalprice + $order->user->township->deliveryprice }}</td>
        <td>{{ $order->created_at }}</td>
        @if(Auth::user()->role_id == 1)
        <td  data-th="">
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
            <a href="{{ route('deliverystatus', $order->id) }}" class="btn btn-outline-success">Complete</a>
            @endif
        </td>
        @else
        <td  data-th="">
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
@endsection
