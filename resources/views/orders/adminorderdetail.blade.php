@extends('layouts.adminindex')


@section('contents')
<div class="card">
  <div class="card-header">
      <h4>{{ $orderdetails[0]->user->name }}'s Order Detail</h4>
  </div>
  <div class="card-body">
      <strong>Order_id = {{ $orderdetails[0]->order->order_id }}</strong><br>
      <strong>OrderDate = {{ $orderdetails[0]->order->created_at }}</strong>
  
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Qty</th>
                <th scope="col" class="text-right">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderdetails as $orderdetail)
                <tr>
                    <td>{{ $orderdetail->name }}</td>
                    <td>{{ $orderdetail->quantity }}</td>
                    <td class="text-right">{{ $orderdetail->totalprice }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2" class="text-center">Delivery Price</th>
                <td class="text-right">{{ $orderdetail->user->township->deliveryprice }}</td>
            </tr>
            <tr>
                <th colspan="2" class="text-center">Grand Total</th>
                <th class="text-right">{{ $orderdetail->order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
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
            <td>{{ $orderdetail->user->name }}</td>
            <td>{{ $orderdetail->user->phone }}</td>
            <td>{{ $orderdetail->user->address }}</td>
            
            </tr>
        </tbody>
        </table>
        @if($orderdetail->order->delivery_id != null)
        <br>
        <h4>Delivery</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                </tr>
            </thead>
            <tbody>                
                <tr>
                    <td>{{ $delivery->name }}</td>
                    <td>{{ $delivery->phone }}</td>
                </tr>                
            </tbody>
        </table>
        @endif
        <td>
            @if($orderdetail->order->deliverystatus == 1)                   
                <button class="btn btn-success">Order Pepare</button>
            @endif
            @if($orderdetail->order->deliverystatus == 2)                  
             <button class="btn btn-secondary">Delivery</button>
            @endif
            @if($orderdetail->order->deliverystatus == 3)
                <button class="btn btn-info">Payment</button>
            @endif
            @if($orderdetail->order->deliverystatus == 4)
                <button class="btn btn-success">Complete</button>
            @endif
        </td>
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
