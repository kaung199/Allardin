@extends('layouts.adminindex')

@section('contents')

<h3>Order_cart <span class="text-warning">({{ $count }})</span></h3>
<div class="row">
    <?php $totalq = 0; $totalp = 0; ?>
    @foreach($orders as $order)
        <div class="col-md-4 pt-2">
            <div class="card" style="width: 16rem;">
                <div class="card-body">
                    <table class="table-bordered">
                       
                        <tr>
                            <th>CustomerName</th>
                            <td>{{ $order->name }}</td>
                        </tr>
                        <!-- @foreach($order->cart_products as $cart)
                            <?php 
                                $totalq += $cart->quantity;
                                $price = $cart->price * $cart->quantity;
                                $totalp += $price; 
                            ?>
                        @endforeach -->
                        <tr>
                            <th>Phone</th>
                            <td>{{ $order->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <th>DeliveryDate</th>
                            <td>{{ $order->delivery_date }}</td>
                        </tr>
                    </table>
                    <div class="bt-2 btnpad" style="padding-top:5px;">
                        <a href="{{  route('admin_cart_detail', $order->id) }}" class="btn btn-primary">Detail</a>
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
