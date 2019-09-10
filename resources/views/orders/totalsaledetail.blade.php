@extends('layouts.adminlayout')

@section('title')
    Total Sale 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('totalsale')}}">Totalsale Product</a> </li>
    <li class="breadcrumb-item active">{{ $product->product->name }}'s Detail </li>
@endsection
@section('contents') 
    <div class="table-responsive">
        <div class="container">
            <div class="row pb-2">
                <div class="col-md-6">
                    <h3>{{ $product->product->name }}'s Detail</h3> 
                </div>
                <div class="col-md-6">
                    <div class="folat-right" style="float: right;">
                        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchtotal') }}" method="POST">
                            @csrf
                            <div class="input-group">
                            <label for="from">From</label>
                            <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="from" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                            <label for="to">To</label>
                            <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="to" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                            <input type="hidden" name="p_id" value="{{ $totalsales[0]->tsp_id }}">
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
        
        <table class="table" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th scope="col">Customers</th>
            <th scope="col">Deli_status</th>
            <th scope="col">Date</th>
            <th scope="col" class="text-right">Total Quantity</th>
            <th scope="col" class="text-right">Total Price</th>
            <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($totalsales as $totalsale) 
            <tr>
                <td>{{  $totalsale->user->name}}</td>
                <td>
                    @if($totalsale->order->deliverystatus == 1)
                        <div class="text-primary">Orderprepare</div>
                    @endif
                    @if($totalsale->order->deliverystatus == 2)
                    <div class="text-secondary">Delivery</div>
                    @endif
                    @if($totalsale->order->deliverystatus == 3)
                        <div class="text-info">Payment</div>
                    @endif
                    @if($totalsale->order->deliverystatus == 4)
                        <div class="text-success">Complete</div>
                    @endif
                </td>
                <td>{{ $totalsale->created_at }}</td>  
                <td class="text-right">{{ $totalsale->totalqty }}</td>
                <td class="text-right">{{ $totalsale->totalprice }}</td>  
                <td class="text-center">
                    <a href="{{ route('customerdetail', $totalsale->user->id) }}" class="btn btn-primary">Detail</a>
                </td>
            </tr>
            @endforeach            
        </tbody>
        </table>
    </div>
    <div class="text-center">{{ $totalsales->links() }}</div>
    
 

@endsection
