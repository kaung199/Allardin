@extends('layouts.orderprepare')

@section('contents') 
@if(Auth::user()->role_id == 3)
<form class="d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchdo', Auth::user()->id) }}" method="GET">
    @csrf
    <div class="input-group">
        <label for="from">From</label>
        <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="ddfrom" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
        <label for="to">To</label>
        <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="ddto" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit" value="search">
            <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>
<hr>
@endif
<div class="row">
    @foreach($orders as $order)
        <div class="col-md-4 pt-2">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <table class="table-bordered">
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
                            <th>TotalQty</th>
                            <td>{{ $order->totalquantity }}</td>
                        </tr>
                        <tr>
                            <th>DeliveryDate</th>
                            <td>{{ $order->deliverydate }}</td>
                        </tr>
                        <tr>
                            <th>TotalPrice</th>
                            <td class="text-danger">{{ $order->totalprice + $order->user->township->deliveryprice }}</td>
                        </tr>
                    </table>
                    <div class="bt-2" style="padding-top:5px;">
                    @if($order->deliverystatus == 1)
                        @if(Auth::user()->role_id == 4)
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal{{ $order->id }}">
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
                                        'route'=> ['orderdeliveryp', $order->id], 
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
                   
                        @else
                        <button class="btn btn-success" disabled>Order Pepare</button>
                        @endif
                    @endif
                    @if($order->deliverystatus == 2)
                        @if(Auth::user()->role_id == 3)
                              <a href="{{ route('deliverystatusd', $order->id)}}" class="btn btn-secondary">Delivery</a>              
                        @else
                        <button class="btn btn-secondary" disabled>Delivery</button>
                        @endif
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
                        <a href="{{ route('orderdetailp', $order->id) }}" class="btn btn-primary">Detail</a>
                    @endif
                    </div>
                    
                </div>
                
            </div>
        </div>
    @endforeach
</div>
<div class="text-center">{{ $orders->links() }}</div>
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
