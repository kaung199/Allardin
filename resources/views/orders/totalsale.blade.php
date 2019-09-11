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
            <div class="col-md-6">
                <h3>Daily Orders</h3>               
            </div>
            <div class="col-md-6">
                <div class="folat-right" style="float: right;">
                    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('searchbydatedaily') }}" method="POST">
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
        <table class="table" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Date</th>
            <th scope="col" class="text-right">Unit Price</th>
            <th scope="col" class="text-right">Total Quantity</th>
            <th scope="col" class="text-right">Total Delivery Price</th>
            <th scope="col" class="text-right">Total Price</th>
            <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($totalsales as $totalsale)            
            <tr>
                <td>{{  $totalsale->product->name}}</td>
                <td>{{  $totalsale->date}}</td>
                <td class="text-right">{{  $totalsale->product->price}}</td>
                <td class="text-right">{{ $totalsale->totalqty }}</td>
                <td class="text-right">{{ $totalsale->deliveryprice }}</td>
                <td class="text-right">{{ $totalsale->totalprice }}</td>  
                <td class="text-center">
                    <a href="{{ route('totalsaledetail', $totalsale->id) }}" class="btn btn-primary">Detail</a>
                </td>
            </tr>
            <?php $grandtotal += $totalsale->totalprice ?>
            @endforeach            
        </tbody>
        </table>
    
    <table class="table table-bordered">
        <tr>
            <th colspan="6" class="text-center border">Grand Total</th>
            <th colspan="1"class="text-center border"> {{ $grandtotal }} Ks</th>
        </tr>
    </table>
    </div>
 

@endsection
