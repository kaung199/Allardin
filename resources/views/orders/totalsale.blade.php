@extends('layouts.adminlayout')

@section('title')
    Total Sale 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">TotalSale Products</li>
@endsection
@section('contents') 
    <div class="table-responsive">
    <?php $grandtotal = 0;  ?>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <h3>Daily Orders</h3>               
            </div>
            <div class="col-md-10 text-right">
                <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchbydatedaily') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3 pt-2">
                            <label class="float-right pl-1" for="delivery">Delivery Date</label>
                            <input class="float-right" type="radio" id="delivery" name="search" value="deliverydate" @if($deliverydate || !$deliverydate || !$orderdate)checked @endif>
                        </div>
                        <div class="col-md-3 pt-2">
                            <label class="float-right pl-1" for="orderdate">Order Date</label>
                            <input class="float-right" type="radio" id="orderdate" name="search" value="orderdate" @if($orderdate) checked @endif>
                        </div>
                        <div class="col-md-6 float-right">
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
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    <br>
    <div class="p-3">
        <table class="table" width="100%" cellspacing="0">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col">
                    @if($deliverydate)
                        Delivery Date
                    @endif
                    @if($orderdate)
                    Order Date
                    @endif
                </th>
                <th scope="col" class="text-right">Unit Price</th>
                <th scope="col" class="text-right">Total Quantity</th>
                <th scope="col" class="text-right">Total Price</th>
                {{-- <th scope="col" class="text-center">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $totalsale)            
                <tr>
                    <td>{{  $totalsale->product_name}}</td>
                    @if($from && $to)
                    <td>{{ $from . "/" . $to }}</td>
                    @else 
                    <td>.</td>
                    @endif
                    
                    <td class="text-right">{{  $totalsale->product_price}}</td>
                    @if($from && $to)
                    <td class="text-right">{{ $totalsale->tqty }}</td>
                    <td class="text-right">{{ $totalsale->tp }}</td>  
                    @else
                    <td class="text-right">{{ $totalsale->tqty }}</td>
                    <td class="text-right">{{ $totalsale->tp }}</td> 
                    @endif
                    {{-- <td class="text-center">
                        @if($from && $to)                    
                            <a href="{{ route('totalsalebydate', [$totalsale->product_id, $from, $to]) }}" class="btn btn-primary">Detail</a>                     
                        @endif
                    </td>                 --}}
                </tr>
                @if($from && $to)
                <?php $grandtotal += $totalsale->tp ?>
                @endif
                @endforeach            
            </tbody>
        </table>
    </div>
    
    <table class="table table-bordered">
        <tr>
            <th colspan="6" class="text-center border">Grand Total</th>
            <th colspan="1"class="text-center border"> {{ $grandtotal }} Ks</th>
        </tr>
    </table>
    </div>
 

@endsection
