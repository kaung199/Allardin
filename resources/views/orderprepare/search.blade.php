@extends('layouts.orderprepare')

@section('contents') 
<h3><span class="badge badge-primary">{{ $count }}</span> Orders Found</h3>
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
                            <th>OrderDate</th>
                            <td>{{ $order->created_at }}</td>
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
                                        'route'=> ['orderdeliverypp', $order->id], 
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
                    @if($order->deliverystatus == 2)
                        @if(Auth::user()->role_id == 3)
                              <a href="{{ route('deliverystatusdd', $order->id)}}" class="btn btn-secondary">Delivery</a>              
                        @else
                        <button class="btn btn-secondary">Delivery</button>
                        @endif
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
                        <a href="{{ route('orderdetailp', $order->id) }}" class="btn btn-primary">Detail</a>
                    @endif
                    </div>
                    
                </div>
                
            </div>
        </div>
    @endforeach
</div>
@endsection
