@extends('layouts.adminindex')


@section('contents')
<div class="card">
  <div class="card-header">
      <h4>{{ $order->name }}'s Order_cart Detail</h4>
  </div>
  <div class="card-body">
      <strong>OrderDate = {{ $order->created_at }}</strong><br>
      <strong>DeliveryDate = {{ $order->delivery_date }}</strong>
  
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Qty</th>
                    <th scope="col" class="text-right">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php $gtotal = 0; ?>
                @foreach($order->cart_products as $orderdetail)
                    <tr>
                        <td>{{ $orderdetail->name }}</td>
                        <td>{{ $orderdetail->quantity }}</td>
                        <?php $totalprice = $orderdetail->price * $orderdetail->quantity; $gtotal += $totalprice; ?>
                        <td class="text-right">{{ $totalprice }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2" class="text-center">Delivery Price</th>
                    <td class="text-right">{{ $order->township->deliveryprice }}</td>
                </tr>
                @if($order->discount != null)
                    <tr>
                        <th colspan="2" class="text-center text-danger">Discount Price</th>
                        <td class="text-right text-danger">-{{ $order->discount }}</td>
                    </tr>
                @endif
                <tr>
                    <th colspan="2" class="text-center">Grand Total</th>
                    <th class="text-right">{{ $gtotal + $order->township->deliveryprice - $order->discount }}</th>
                </tr>
            </tbody>
        </table>
        <h4>Customer Information</h4>
        <table class="table table-bordered table-dark">
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
                <td class="maxtd">{{ $order->address }}</td>
                
                </tr>
            </tbody>
        </table>
       
    </div>
    <div class="container pb-2">
        <div class="row text-center">
            <div class="col-md-2 pb-2">
                <a href="{{ route('orders.order_cart_edit', $order->id) }}" class="btn btn-info">Edit Info</a>
            </div>
            <div class="col-md-2 pb-2">
                <a href="{{ route('orders.order_cart_editp', $order->id) }}" class="btn btn-primary">Product Edit</a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('orders.order_cart_confirm', $order->id) }}" class="btn btn-success">Confirm Order</a>
            </div>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
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
