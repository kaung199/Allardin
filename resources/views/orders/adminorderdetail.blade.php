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
            @if($orderdetail->order->discount != null)
                <tr>
                    <th colspan="2" class="text-center text-danger">Discount Price</th>
                    <td class="text-right text-danger">-{{ $orderdetail->order->discount }}</td>
                </tr>
            @endif
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
            <td class="maxtd">{{ $orderdetail->user->address }}</td>
            
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
                <button class="btn btn-success">Order Prepare</button>
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
        <a href="{{ route('o_prepare', $orderdetail->order->id)  }}" class="btn btn-primary">Check Products</a>

    </div>
</div>

<div class="printposition  displaynone table-responsive">
  <div class="print">
    <div class="container">
      <div class="text-center aladdinh2">
        <h2>Aladdin Online Shop (09-686781222)</h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h3>
            {{ $orderdetails[0]->user->name }}'s Order Detail
          </h3>
        </div>
        <div class="col-md-6 pb-1">
          <div class="float-right">
                  @php
                      echo DNS1D::getBarcodeSVG($orderdetails[0]->order->order_id, "C39",1,44);
                  @endphp
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
              <th scope="col">DeliveryDate</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $delivery->name }}</td>
              <td>{{ $delivery->phone }}</td>
              <td>{{ $orderdetail->order->deliverydate }}</td>
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
        <h2>Aladdin Online Shop (09-686781222)</h2>
      </div>
        <div class="row">
          <div class="col-md-6">
            <h3>
              {{ $orderdetails[0]->user->name }}'s Order Detail
            </h3>
          </div>
          <div class="col-md-6 pb-1">
            <div class="float-right">
                  @php
                      echo DNS1D::getBarcodeSVG($orderdetails[0]->order->order_id, "C39",1,44);
                  @endphp
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
        <div>
          @if($orderdetail->order->delivery_id != null)
        
          <h4>Delivery</h4>
          <table class="table table-bordered ">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">DeliveryDate</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $delivery->name }}</td>
                <td>{{ $delivery->phone }}</td>
                <td>{{ $orderdetail->order->deliverydate }}</td>
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
    
    <div class="print2">
      <div class="hr"></div>
      <div class="container">
      <div class="text-center aladdinh2">
        <h2>Aladdin Online Shop (09-686781222)</h2>
      </div>
        <div class="row">
          <div class="col-md-6">
            <h3>
              {{ $orderdetails[0]->user->name }}'s Order Detail
            </h3>
          </div>
          <div class="col-md-6 pb-1">
            <div class="float-right">
                @php
                    echo DNS1D::getBarcodeSVG($orderdetails[0]->order->order_id, "C39",1,44);
                @endphp
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
        <div>
          @if($orderdetail->order->delivery_id != null)
          
          <h4>Delivery</h4>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">DeliveryDate</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $delivery->name }}</td>
                <td>{{ $delivery->phone }}</td>
                <td>{{ $orderdetail->order->deliverydate }}</td>
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
  
  <script>
    window.onkeyup = function(e) {
        if (e.keyCode == 8) window.history.back();
      }
  </script>
    
@endsection
