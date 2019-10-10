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
                            <th>TotalQty</th>
                            <td>{{ $order->totalquantity }}</td>
                        </tr>
                        <tr>
                            <th>TotalPrice</th>
                            <td>{{ $order->totalprice + $order->user->township->deliveryprice }}</td>
                        </tr>
                        <tr>
                            <th>DeliveryDate</th>
                            <td>{{ $order->deliverydate }}</td>
                        </tr>
                        <tr>
                            <th>Delivery Name</th>
                            <td>{{ $order->dname }}</td>
                        </tr>
                    </table>
                    <div class="bt-2" style="padding-top:5px;">
                    @if($order->deliverystatus == 1)
                    <button class="btn btn-success">Order Pepare</button>
                    @endif
                    @if($order->deliverystatus == 2)                       
                    <button class="btn btn-secondary">Delivery</button>
                    @endif
                    @if($order->deliverystatus == 3)
                    <button class="btn btn-info">Payment</button>
                    @endif
                    @if($order->deliverystatus == 4)
                    <button class="btn btn-success">Complete</button>
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
<div class="text-center">{{ $orders->links() }}</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    @if(session('deliverystatus'))        
            Swal.fire({
                title: 'Delivery Status Updated Successfuly',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })    
    @endif
    @if(session('ordersuccess'))        
            Swal.fire({
                title: 'Order Successfuly',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })    
    @endif
    @if(session('permission'))
            Swal.fire({
                title: 'Permission Access Deny !!Ask Admin!!',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })    
    @endif
</script>

@endsection
