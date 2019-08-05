@extends('layouts.adminlayout')

@section('title')
    Orders
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Order</li>
@endsection
@section('contents')

<h3>
        {{ $orderdetails[0]->user->name }}'s Order Detail
</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Order_id</th>
      <th scope="col">Product Name</th>
      <th scope="col">Qty</th>
      <th scope="col" class="text-right">Price</th>
      <th scope="col">Order Date</th>
      <th scope="col">Delivery Status</th>
      <th scope="col" class="text-right">Total Price</th>

    </tr>
  </thead>
  <tbody>
        @foreach($orderdetails as $orderdetail) 
            <tr>
                <th scope="row">{{ $orderdetail->order->id }}</th>
                <td>{{ $orderdetail->name }}</td>
                <td>{{ $orderdetail->quantity }}</td>
                <td class="text-right">{{ $orderdetail->price }}</td>
                <td>{{ $orderdetail->created_at }}</td>
                <td>{{ $orderdetail->order->deliverystatus }}</td>
                <td class="text-right">{{ $orderdetail->totalprice }}</td>

            </tr>
        @endforeach
        <tr>
            <th colspan="6" class="text-center">Delivery Price</th>
            <td class="text-right">{{ $orderdetail->user->township->deliveryprice }}</td>
        </tr>
        <tr>
            <th colspan="6" class="text-center">Grand Total</th>
            <th class="text-right">{{ $orderdetail->order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
        </tr>
        
  </tbody>
</table>
<br>
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
@endsection
