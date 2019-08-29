@extends('layouts.orderprepare')


@section('contents')
<div class="container">
  <div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
      <div class="float-right">
        @if($previous)
        <a href="{{ URL::to( 'orderdetailpo/' . $previous ) }}" class="btn btn-outline-secondary text-dark text-decoration-none"><i class="fas fa-backward"></i> Previous</a>
        @endif
        @if($next)
        <a href="{{ URL::to( 'orderdetailpo/' . $next ) }}" class="btn btn-outline-secondary text-dark text-decoration-none">Next <i class="fas fa-forward"></i></a>
        @endif
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
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
                    @if(Auth::user()->role_id == 4)
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal{{ $orderdetail->order->id }}">
                        Order Prepare
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $orderdetail->order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Choose Delivery Man</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {{ Form::model($order, [ 
                                    'route'=> ['orderdeliveryp', $orderdetail->order->id], 
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
                    <button class="btn btn-success">Order Pepare</button>
                    @endif
                @endif
                @if($orderdetail->order->deliverystatus == 2)
                    @if(Auth::user()->role_id == 3)
                            <a href="{{ route('deliverystatusd', $orderdetail->order->id)}}" class="btn btn-secondary">Delivery</a>              
                    @else
                    <button class="btn btn-secondary">Delivery</button>
                    @endif
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
