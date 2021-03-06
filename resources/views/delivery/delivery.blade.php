@extends('layouts.orderprepare')

@section('contents') 
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
@if($count)
<span class="badge badge-success">( {{ $count }} )Results</span> 
@endif
@if($orders[0])
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
                            <th>DeliveryDate</th>
                            <td>{{ $order->deliverydate }}</td>
                        </tr>
                        <tr>
                            <th>TotalQty</th>
                            <td>{{ $order->totalquantity }}</td>
                        </tr>
                        <tr>
                            <th>TotalPrice</th>
                            <td class="text-danger">{{ $order->totalprice + $order->user->township->deliveryprice }}</td>
                        </tr>
                    </table>
                    <div class="bt-2" style="padding-top:5px;">
                        @if($order->deliverystatus == 1)
                        <a href="#" class="btn btn-primary disabled">OrderPrepare</a>  
                        @endif
                        @if($order->deliverystatus == 2)
                        <a href="{{ route('deliverystatusd', $order->id) }}" class="btn btn-secondary">Delivery</a>  
                        @endif
                        @if($order->deliverystatus == 3)
                        <a href="#" class="btn btn-info disabled">Payment</a>  
                        @endif
                        @if($order->deliverystatus == 4)
                        <a href="#" class="btn btn-success disabled">Complete</a>  
                        @endif
                        <a href="{{ route('orderdetaild', $order->id) }}" class="btn btn-primary">Detail</a>

                    </div>
                    
                </div>
                
            </div>
        </div>
    @endforeach
</div>
@else
<h2 class="text-center pt-5 pb-5">No Orders Yet</h2>
@endif
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
