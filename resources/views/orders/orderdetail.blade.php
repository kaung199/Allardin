@extends('layouts.adminlayout')

@section('title')
    Orders
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"> <a href="{{ url('order') }}">Order</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection
@section('contents')
<div class="printposition table-responsive">
  <div class="print">
    <div class="container">
      <div class="text-center aladdinh2">
        <h2>Aladdin Online Shop</h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h3>
            {{ $orderdetails[0]->user->name }}'s Order Detail
          </h3>
        </div>
        <div class="col-md-6 hide">
          <div class="float-right">
            @if($previous)
            <a href="{{ URL::to( 'orderdetail/' . $previous ) }}" class="btn btn-outline-light text-dark text-decoration-none"><i class="fas fa-backward"></i> Previous</a>
            @endif
            @if($next)
            <a href="{{ URL::to( 'orderdetail/' . $next ) }}" class="btn btn-outline-light text-dark text-decoration-none">Next <i class="fas fa-forward"></i></a>
            @endif
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>



    <table class="table table-bordered ">
      <thead>
        <tr>
          <th scope="col">Order_id</th>
          <th scope="col">Product Name</th>
          <th scope="col">Qty</th>
          <th scope="col" class="text-right">Price</th>
          <th scope="col">Order Date</th>
          <th scope="col" class="hide">Delivery Status</th>
          <th scope="col" class="text-right">Total Price</th>

        </tr>
      </thead>
      <tbody>
            @foreach($orderdetails as $orderdetail) 
                <tr>
                    <th scope="row">{{ $orderdetail->order->order_id }}</th>
                    <td>{{ $orderdetail->name }}</td>
                    <td>{{ $orderdetail->quantity }}</td>
                    <td class="text-right">{{ $orderdetail->price }}</td>
                    <td>{{ $orderdetail->created_at }}</td>
                    @if(Auth::user()->role_id == 1)
                      <td class="hide">
                        @if($orderdetail->order->deliverystatus == 1)
                            <!-- Button trigger modal -->
                          <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $order->id }}">
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
                              @if(Auth::user()->role_id ==4 )
                              {{ Form::model($order, [ 
                                      'route'=> ['orderdeliveryp', $orderdetail->order->id], 
                                      'method' => 'POST',
                                  ]) }}
                              @else
                              {{ Form::model($order, [ 
                                      'route'=> ['orderdelivery', $orderdetail->order->id], 
                                      'method' => 'POST',
                                  ]) }}
                              @endif
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
                        @endif
                        @if($orderdetail->order->deliverystatus == 2)
                        <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-secondary">Delivery</a>
                        @endif
                        @if($orderdetail->order->deliverystatus == 3)
                        <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-info">Payment</a>
                        @endif
                        @if($orderdetail->order->deliverystatus == 4)
                        <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-success">Complete</a>
                        @endif
                      </td>
                    @else
                    <td>
                      @if($orderdetail->order->deliverystatus == 1)
                      <a href="#" class="btn btn-outline-primary">Order Prepare</a>
                      @endif
                      @if($orderdetail->order->deliverystatus == 2)
                      <a href="#" class="btn btn-outline-secondary">Delivery</a>
                      @endif
                      @if($orderdetail->order->deliverystatus == 3)
                      <a href="#" class="btn btn-outline-info">Payment</a>
                      @endif
                      @if($orderdetail->order->deliverystatus == 4)
                      <a href="#" class="btn btn-outline-success">Complete</a>
                      @endif
                    </td>
                    @endif
                    <td class="text-right">{{ $orderdetail->totalprice }}</td>

                </tr>
            @endforeach
            <div class="tr_show">
              <tr class="tr_show">
                  <th colspan="6" class="text-center">Delivery Price</th>
                  <td class="text-right">{{ $orderdetail->user->township->deliveryprice }}</td>
              </tr>
              @if($orderdetail->order->discount != null)
                <tr class="tr_show">
                    <th colspan="6" class="text-center text-danger">Discount Price</th>
                    <td class="text-right text-danger">-{{ $orderdetail->order->discount }}</td>
                </tr>
              @endif
              <tr class="tr_show">
                  <th colspan="6" class="text-center">Grand Total</th>
                  <th class="text-right">{{ $orderdetail->order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
              </tr>
            </div>
            <div class="tr_hide">
              <tr class="tr_hide">
                  <th colspan="5" class="text-center">Delivery Price</th>
                  <td class="text-right">{{ $orderdetail->user->township->deliveryprice }}</td>
              </tr>
              @if($orderdetail->order->discount != null)
                <tr class="tr_hide">
                    <th colspan="5" class="text-center text-danger">Discount Price</th>
                    <td class="text-right text-danger">-{{ $orderdetail->order->discount }}</td>
                </tr>
              @endif
              <tr class="tr_hide">
                  <th colspan="5" class="text-center">Grand Total</th>
                  <th class="text-right">{{ $orderdetail->order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
              </tr>
            </div>
            
      </tbody>
    </table>
    <div class="cusmt">
      <h4>Customer Information</h4>
      <table class="table table-bordered table-dark ">
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
      <div>
        @if($orderdetail->order->delivery_id != null)
        
        <h4>Delivery</h4>
        <table class="table table-bordered ">
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
      </div>
      @if($orderdetail->order->remark)
      <strong>Remark => </strong>
      {{ $orderdetail->order->remark }}
      @endif
    </div>
    
  </div>
  <div class="print12hide">
    <div class="print1">
      <div class="hr"></div>
      <div class="container">
      <div class="text-center aladdinh2">
        <h2>Aladdin Online Shop</h2>
      </div>
        <div class="row">
          <div class="col-md-6">
            <h3>
              {{ $orderdetails[0]->user->name }}'s Order Detail
            </h3>
          </div>
          <div class="col-md-6 hide">
            <div class="float-right">
              @if($previous)
              <a href="{{ URL::to( 'orderdetail/' . $previous ) }}" class="btn btn-outline-light text-dark text-decoration-none"><i class="fas fa-backward"></i> Previous</a>
              @endif
              @if($next)
              <a href="{{ URL::to( 'orderdetail/' . $next ) }}" class="btn btn-outline-light text-dark text-decoration-none">Next <i class="fas fa-forward"></i></a>
              @endif
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>



      <table class="table table-bordered ">
        <thead>
          <tr>
            <th scope="col">Order_id</th>
            <th scope="col">Product Name</th>
            <th scope="col">Qty</th>
            <th scope="col" class="text-right">Price</th>
            <th scope="col">Order Date</th>
            <th scope="col" class="hide">Delivery Status</th>
            <th scope="col" class="text-right">Total Price</th>

          </tr>
        </thead>
        <tbody>
              @foreach($orderdetails as $orderdetail) 
                  <tr>
                      <th scope="row">{{ $orderdetail->order->order_id }}</th>
                      <td>{{ $orderdetail->name }}</td>
                      <td>{{ $orderdetail->quantity }}</td>
                      <td class="text-right">{{ $orderdetail->price }}</td>
                      <td>{{ $orderdetail->created_at }}</td>
                      @if(Auth::user()->role_id == 1)
                        <td class="hide">
                          @if($orderdetail->order->deliverystatus == 1)
                              <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $order->id }}">
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
                                @if(Auth::user()->role_id ==4 )
                                {{ Form::model($order, [ 
                                        'route'=> ['orderdeliveryp', $orderdetail->order->id], 
                                        'method' => 'POST',
                                    ]) }}
                                @else
                                {{ Form::model($order, [ 
                                        'route'=> ['orderdelivery', $orderdetail->order->id], 
                                        'method' => 'POST',
                                    ]) }}
                                @endif
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
                          @endif
                          @if($orderdetail->order->deliverystatus == 2)
                          <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-secondary">Delivery</a>
                          @endif
                          @if($orderdetail->order->deliverystatus == 3)
                          <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-info">Payment</a>
                          @endif
                          @if($orderdetail->order->deliverystatus == 4)
                          <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-success">Complete</a>
                          @endif
                        </td>
                      @else
                      <td>
                        @if($orderdetail->order->deliverystatus == 1)
                        <a href="#" class="btn btn-outline-primary">Order Prepare</a>
                        @endif
                        @if($orderdetail->order->deliverystatus == 2)
                        <a href="#" class="btn btn-outline-secondary">Delivery</a>
                        @endif
                        @if($orderdetail->order->deliverystatus == 3)
                        <a href="#" class="btn btn-outline-info">Payment</a>
                        @endif
                        @if($orderdetail->order->deliverystatus == 4)
                        <a href="#" class="btn btn-outline-success">Complete</a>
                        @endif
                      </td>
                      @endif
                      <td class="text-right">{{ $orderdetail->totalprice }}</td>

                  </tr>
              @endforeach
              <div class="tr_show">
                <tr class="tr_show">
                    <th colspan="6" class="text-center">Delivery Price</th>
                    <td class="text-right">{{ $orderdetail->user->township->deliveryprice }}</td>
                </tr>
                        
                <tr class="tr_show">
                    <th colspan="6" class="text-center">Grand Total</th>
                    <th class="text-right">{{ $orderdetail->order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
                </tr>
              </div>
              <div class="tr_hide">
                <tr class="tr_hide">
                    <th colspan="5" class="text-center">Delivery Price</th>
                    <td class="text-right">{{ $orderdetail->user->township->deliveryprice }}</td>
                </tr>
                @if($orderdetail->order->discount != null)
                  <tr class="tr_hide">
                      <th colspan="5" class="text-center text-danger">Discount Price</th>
                      <td class="text-right text-danger">-{{ $orderdetail->order->discount }}</td>
                  </tr>
                @endif
                <tr class="tr_hide">
                    <th colspan="5" class="text-center">Grand Total</th>
                    <th class="text-right">{{ $orderdetail->order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
                </tr>
              </div>
              
        </tbody>
      </table>
      <div class="cusmt">
        <h4>Customer Information</h4>
        <table class="table table-bordered table-dark ">
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
        <div class="deliverycss">
          @if($orderdetail->order->delivery_id != null)
        
          <h4>Delivery</h4>
          <table class="table table-bordered ">
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
        </div>
      </div>
      
    </div>
    
    <div class="print2">
      <div class="hr"></div>
      <div class="container">
      <div class="text-center aladdinh2">
        <h2>Aladdin Online Shop</h2>
      </div>
        <div class="row">
          <div class="col-md-6">
            <h3>
              {{ $orderdetails[0]->user->name }}'s Order Detail
            </h3>
          </div>
          <div class="col-md-6 hide">
            <div class="float-right">
              @if($previous)
              <a href="{{ URL::to( 'orderdetail/' . $previous ) }}" class="btn btn-outline-light text-dark text-decoration-none"><i class="fas fa-backward"></i> Previous</a>
              @endif
              @if($next)
              <a href="{{ URL::to( 'orderdetail/' . $next ) }}" class="btn btn-outline-light text-dark text-decoration-none">Next <i class="fas fa-forward"></i></a>
              @endif
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>



      <table class="table table-bordered ">
        <thead>
          <tr>
            <th scope="col">Order_id</th>
            <th scope="col">Product Name</th>
            <th scope="col">Qty</th>
            <th scope="col" class="text-right">Price</th>
            <th scope="col">Order Date</th>
            <th scope="col" class="hide">Delivery Status</th>
            <th scope="col" class="text-right">Total Price</th>

          </tr>
        </thead>
        <tbody>
              @foreach($orderdetails as $orderdetail) 
                  <tr>
                      <th scope="row">{{ $orderdetail->order->order_id }}</th>
                      <td>{{ $orderdetail->name }}</td>
                      <td>{{ $orderdetail->quantity }}</td>
                      <td class="text-right">{{ $orderdetail->price }}</td>
                      <td>{{ $orderdetail->created_at }}</td>
                      @if(Auth::user()->role_id == 1)
                        <td class="hide">
                          @if($orderdetail->order->deliverystatus == 1)
                              <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $order->id }}">
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
                                @if(Auth::user()->role_id ==4 )
                                {{ Form::model($order, [ 
                                        'route'=> ['orderdeliveryp', $orderdetail->order->id], 
                                        'method' => 'POST',
                                    ]) }}
                                @else
                                {{ Form::model($order, [ 
                                        'route'=> ['orderdelivery', $orderdetail->order->id], 
                                        'method' => 'POST',
                                    ]) }}
                                @endif
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
                          @endif
                          @if($orderdetail->order->deliverystatus == 2)
                          <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-secondary">Delivery</a>
                          @endif
                          @if($orderdetail->order->deliverystatus == 3)
                          <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-info">Payment</a>
                          @endif
                          @if($orderdetail->order->deliverystatus == 4)
                          <a href="{{ route('deliverystatus', $orderdetail->order->id) }}" class="btn btn-outline-success">Complete</a>
                          @endif
                        </td>
                      @else
                      <td>
                        @if($orderdetail->order->deliverystatus == 1)
                        <a href="#" class="btn btn-outline-primary">Order Prepare</a>
                        @endif
                        @if($orderdetail->order->deliverystatus == 2)
                        <a href="#" class="btn btn-outline-secondary">Delivery</a>
                        @endif
                        @if($orderdetail->order->deliverystatus == 3)
                        <a href="#" class="btn btn-outline-info">Payment</a>
                        @endif
                        @if($orderdetail->order->deliverystatus == 4)
                        <a href="#" class="btn btn-outline-success">Complete</a>
                        @endif
                      </td>
                      @endif
                      <td class="text-right">{{ $orderdetail->totalprice }}</td>

                  </tr>
              @endforeach
              <div class="tr_show">
                <tr class="tr_show">
                    <th colspan="6" class="text-center">Delivery Price</th>
                    <td class="text-right">{{ $orderdetail->user->township->deliveryprice }}</td>
                </tr>
                <tr class="tr_show">
                    <th colspan="6" class="text-center">Grand Total</th>
                    <th class="text-right">{{ $orderdetail->order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
                </tr>
              </div>
              <div class="tr_hide">
                <tr class="tr_hide">
                    <th colspan="5" class="text-center">Delivery Price</th>
                    <td class="text-right">{{ $orderdetail->user->township->deliveryprice }}</td>
                </tr>
                @if($orderdetail->order->discount != null)
                  <tr class="tr_hide">
                      <th colspan="5" class="text-center text-danger">Discount Price</th>
                      <td class="text-right text-danger">-{{ $orderdetail->order->discount }}</td>
                  </tr>
                @endif
                <tr class="tr_hide">
                    <th colspan="5" class="text-center">Grand Total</th>
                    <th class="text-right">{{ $orderdetail->order->totalprice + $orderdetail->user->township->deliveryprice }}</th>
                </tr>
              </div>
              
        </tbody>
      </table>
      
      <div class="cusmt">
        <h4>Customer Information</h4>
        <table class="table table-bordered table-dark ">
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
        <div class="deliverycss">
          @if($orderdetail->order->delivery_id != null)
          
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
        </div>
      </div>
      
    </div>
  </div>
</div>

<button class="btn btn-success" onclick="window.print()">Print</button>
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
