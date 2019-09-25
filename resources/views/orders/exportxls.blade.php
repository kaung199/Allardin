@extends('layouts.adminlayout')

@section('title')
    Orders Daily
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"> <a href="{{ url('order') }}">Order</a></li>
    <li class="breadcrumb-item active">DailyOrder</li>
@endsection
@section('contents') 
<div class="container">
    <div class="row">
        <div class="col-md-6">
        <button onclick="exportTableToExcel('tblData', dateTime)">Export Excel File</button>
        </div>
        <div class="col-md-6">
            <div class="folat-right" style="float: right;">
                <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchxls') }}" method="GET">
                    @csrf
                    <div class="input-group">
                    <label for="from">From</label>
                    <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="from" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                    <label for="to">To</label>
                    <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="to" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" value="search">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
@if($orderso[0] != null)
<div class="table-responsive-sm shadow p-3">
    <h3>OrderPrepare</h3>
    <table class="table table-primary">
        <thead>
            <tr>
            <th scope="col">Order_id</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Total Qty</th>
            <th scope="col" class="text-right">Total Price</th>
            <th scope="col">Order Date</th>
            <th scope="col">Delivery Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderso as $ordero)
                <tr>
                    <th scope="row">{{ $ordero->order_id }}</th>
                    <td>{{ $ordero->user->name }}</td>
                    <td>{{ $ordero->totalquantity }}</td>
                    <td class="text-right">{{ $ordero->totalprice + $ordero->user->township->deliveryprice }}</td>
                    <td>{{ $ordero->created_at }}</td>
                    <td  data-th="">
                        @if($ordero->deliverystatus == 1)
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $ordero->id }}">
                            Order Prepare
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $ordero->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Choose Delivery Man</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {{ Form::model($ordero, [ 
                                        'route'=> ['orderdelivery', $ordero->id], 
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
                        @endif
                        @if($ordero->deliverystatus == 2)
                        <a href="{{ route('deliverystatus', $ordero->id) }}" class="btn btn-outline-secondary">Delivery</a>
                        @endif
                        @if($ordero->deliverystatus == 3)
                        <a href="{{ route('deliverystatus', $ordero->id) }}" class="btn btn-outline-info">Payment</a>
                        @endif
                        @if($ordero->deliverystatus == 4)
                        <a href="{{ route('deliverystatus', $ordero->id) }}" class="btn btn-outline-success">Complete</a>
                        @endif
                    </td>
                    <td>
                        {{ Form::model($ordero, [ 
                            'route'=> ['orders.destroy', $ordero->id], 
                            'method' => 'DELETE',
                            'onsubmit' => "return confirm('Are you sure you want to DELETE this ORDER?');"
                        ]) }}
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('orderdetail', $ordero->id) }}">Detail</a>
                                    <button class="dropdown-item">Delete</button>
                                </div>
                            </div>                            
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br>
@endif
@if($ordersd[0] != null)
<div class="table-responsive-sm shadow p-3">
    <h3>Delivery</h3>
    <table class="table table-active">
        <thead>
            <tr>
            <th scope="col">Order_id</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Total Qty</th>
            <th scope="col" class="text-right">Total Price</th>
            <th scope="col">Order Date</th>
            <th scope="col">Delivery Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordersd as $orderd)
                <tr>
                <th scope="row">{{ $orderd->order_id }}</th>
                <td>{{ $orderd->user->name }}</td>
                <td>{{ $orderd->totalquantity }}</td>
                <td class="text-right">{{ $orderd->totalprice + $orderd->user->township->deliveryprice }}</td>
                <td>{{ $orderd->created_at }}</td>
                <td  data-th="">
                    @if($orderd->deliverystatus == 1)
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $orderd->id }}">
                        Order Prepare
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $orderd->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Choose Delivery Man</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {{ Form::model($orderd, [ 
                                    'route'=> ['orderdelivery', $orderd->id], 
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
                    @endif
                    @if($orderd->deliverystatus == 2)
                    <a href="{{ route('deliverystatus', $orderd->id) }}" class="btn btn-outline-secondary">Delivery</a>
                    @endif
                    @if($orderd->deliverystatus == 3)
                    <a href="{{ route('deliverystatus', $orderd->id) }}" class="btn btn-outline-info">Payment</a>
                    @endif
                    @if($orderd->deliverystatus == 4)
                    <a href="{{ route('deliverystatus', $orderd->id) }}" class="btn btn-outline-success">Complete</a>
                    @endif
                </td>
                <td>
                    {{ Form::model($orderd, [ 
                        'route'=> ['orders.destroy', $orderd->id], 
                        'method' => 'DELETE',
                        'onsubmit' => "return confirm('Are you sure you want to DELETE this ORDER?');"
                    ]) }}
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('orderdetail', $orderd->id) }}">Detail</a>
                                <button class="dropdown-item">Delete</button>
                            </div>
                        </div>
                        
                    {{ Form::close() }}
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br>
@endif
@if($ordersp[0] != null)
<div class="table-responsive-sm shadow p-3">
    <h3>Payment</h3>
    <table class="table table-danger">
        <thead>
            <tr>
            <th scope="col">Order_id</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Total Qty</th>
            <th scope="col" class="text-right">Total Price</th>
            <th scope="col">Order Date</th>
            <th scope="col">Delivery Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordersp as $orderp)
                <tr>
                <th scope="row">{{ $orderp->order_id }}</th>
                <td>{{ $orderp->user->name }}</td>
                <td>{{ $orderp->totalquantity }}</td>
                <td class="text-right">{{ $orderp->totalprice + $orderp->user->township->deliveryprice }}</td>
                <td>{{ $orderp->created_at }}</td>
                <td  data-th="">
                    @if($orderp->deliverystatus == 1)
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $orderp->id }}">
                        Order Prepare
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $orderp->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Choose Delivery Man</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {{ Form::model($orderp, [ 
                                    'route'=> ['orderdelivery', $orderp->id], 
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
                    @endif
                    @if($orderp->deliverystatus == 2)
                    <a href="{{ route('deliverystatus', $orderp->id) }}" class="btn btn-outline-secondary">Delivery</a>
                    @endif
                    @if($orderp->deliverystatus == 3)
                    <a href="{{ route('deliverystatus', $orderp->id) }}" class="btn btn-outline-info">Payment</a>
                    @endif
                    @if($orderp->deliverystatus == 4)
                    <a href="{{ route('deliverystatus', $orderp->id) }}" class="btn btn-outline-success">Complete</a>
                    @endif
                </td>
                <td>
                    {{ Form::model($orderp, [ 
                        'route'=> ['orders.destroy', $orderp->id], 
                        'method' => 'DELETE',
                        'onsubmit' => "return confirm('Are you sure you want to DELETE this ORDER?');"
                    ]) }}
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('orderdetail', $orderp->id) }}">Detail</a>
                                <button class="dropdown-item">Delete</button>
                            </div>
                        </div>
                        
                    {{ Form::close() }}
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br>
@endif
@if($ordersc[0] != null)
<div class="table-responsive-sm shadow p-3">
    <h3>Complete</h3>
    <table class="table table-success">
        <thead>
            <tr>
            <th scope="col">Order_id</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Total Qty</th>
            <th scope="col" class="text-right">Total Price</th>
            <th scope="col">Order Date</th>
            <th scope="col">Delivery Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordersc as $orderc)
                <tr>
                <th scope="row">{{ $orderc->order_id }}</th>
                <td>{{ $orderc->user->name }}</td>
                <td>{{ $orderc->totalquantity }}</td>
                <td class="text-right">{{ $orderc->totalprice + $orderc->user->township->deliveryprice }}</td>
                <td>{{ $orderc->created_at }}</td>
                <td  data-th="">
                    @if($orderc->deliverystatus == 1)
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $orderc->id }}">
                        Order Prepare
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $orderc->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Choose Delivery Man</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {{ Form::model($orderc, [ 
                                    'route'=> ['orderdelivery', $orderc->id], 
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
                    @endif
                    @if($orderc->deliverystatus == 2)
                    <a href="{{ route('deliverystatus', $orderc->id) }}" class="btn btn-outline-secondary">Delivery</a>
                    @endif
                    @if($orderc->deliverystatus == 3)
                    <a href="{{ route('deliverystatus', $orderc->id) }}" class="btn btn-outline-info">Payment</a>
                    @endif
                    @if($orderc->deliverystatus == 4)
                    <a href="{{ route('deliverystatus', $orderc->id) }}" class="btn btn-outline-success">Complete</a>
                    @endif
                </td>
                <td>
                    {{ Form::model($orderc, [ 
                        'route'=> ['orders.destroy', $orderc->id], 
                        'method' => 'DELETE',
                        'onsubmit' => "return confirm('Are you sure you want to DELETE this ORDER?');"
                    ]) }}
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('orderdetail', $orderc->id) }}">Detail</a>
                                <button class="dropdown-item">Delete</button>
                            </div>
                        </div>
                        
                    {{ Form::close() }}
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
    <script>
        function exportTableToExcel(tableID, filename = ''){
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            
            // Specify file name
            filename = filename?filename+'.xls':'excel_data.xls';
            
            // Create download link element
            downloadLink = document.createElement("a");
            
            document.body.appendChild(downloadLink);
            
            if(navigator.msSaveOrOpenBlob){
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob( blob, filename);
            }else{
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            
                // Setting the file name
                downloadLink.download = filename;
                
                //triggering the function
                downloadLink.click();
            }
        }

        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
        console.log(dateTime);
    </script>
@endsection
