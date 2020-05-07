@extends('layouts.pos')

@section('title')
    POS Report
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">POS Sale Report</li>
@endsection
@section('contents') 
<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
        <div class="folat-right" style="float: right;">
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('total-sale') }}" method="GET">
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
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Name</th>
        <th class="text-right">Qty</th>
        <th class="text-right">Price</th>
        <th class="text-right">Total Price</th>
    </tr>
    </thead>
    <tbody>
        @php
            $gt = 0;
        @endphp
    @foreach($saleDetails as $s)
        @php
            $gt += $s->tp;
        @endphp
        
        <tr>
            <td>{{ $s->product->name }}</td>
            <td class="text-right">{{ $s->tqty }}</td>
            <td class="text-right">{{ $s->product->price }}</td>
            <td class="text-right">{{ $s->tp }}</td>
        </tr>
    @endforeach
       
    </tbody>
    <tr>
        <th colspan="3" class="text-center">Grand Total</th>
        <th class="text-right">{{ $gt }}</th>
    </tr>
</table>

     
@endsection
