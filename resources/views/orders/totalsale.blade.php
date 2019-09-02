@extends('layouts.adminlayout')

@section('title')
    Total Sale 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">TotalSale Products</li>
@endsection
@section('contents') 
    <div class="table-responsive">
        <h3>TotalSale Products</h3>
        <table class="table" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th scope="col">Name</th>
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
                <td class="text-right">{{  $totalsale->product->price}}</td>
                <td class="text-right">{{ $totalsale->totalqty }}</td>
                <td class="text-right">{{ $totalsale->deliveryprice }}</td>
                <td class="text-right">{{ $totalsale->totalprice }}</td>  
                <td class="text-center">
                    <a href="{{ route('totalsaledetail', $totalsale->id) }}" class="btn btn-primary">Detail</a>
                </td>
            </tr>
            @endforeach            
        </tbody>
        </table>
    </div>
    <div class="text-center">{{ $totalsales->links() }}</div>
    
 

@endsection
