@extends('layouts.orderprepare')

@section('contents') 

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
                            <th>TotalQty</th>
                            <td>{{ $order->totalquantity }}</td>
                        </tr>
                        <tr>
                            <th>TotalPrice</th>
                            <td>{{ $order->totalprice + $order->user->township->deliveryprice }}</td>
                        </tr>
                        <tr>
                            <th>OrderDate</th>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                    </table>
                    <div class="bt-2" style="padding-top:5px;">
                        <a href="{{ route('deliverystatusd', $order->id) }}" class="btn btn-secondary">Delivery</a>  
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
