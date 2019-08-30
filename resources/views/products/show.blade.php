@extends('layouts.adminlayout')

@section('title')
    Products 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection
@section('contents') 
    <div class="table-responsive">
        <h3>Products</h3>
        <hr>
        <table class="table" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th scope="col">Photo</th>
            <th scope="col">Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Add Order</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @foreach($product->photos as $photo) 
                        <img src="{{ asset('storage/' . $photo->filename) }}" alt="" style="width:50px; height:50px;">
                    @endforeach
                </td>
                <td>{{  $product->name}}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->price }}</td>
                <td> <a href="{{ route('cartadd', $product->id) }}" class="btn btn-primary addtocart"><i class="fas fa-cart-plus"></i>Add Order</a></td>

                <td>
                    {{ Form::model($product, [ 
                        'route'=> ['products.destroy', $product->id], 
                        'method' => 'DELETE',
                        'onsubmit' => "return confirm('Are you sure you want to DELETE?');"
                    ]) }}
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('editdetail', $product->id) }}">Edit</a>
                            <button class="dropdown-item">Delete</button>
                        </div>
                    </div>
                        
                    {{ Form::close() }}
                </td>
            </tr>
            
        </tbody>
        </table>
    </div>
    
    <hr>
    <h4>Description</h4>
    <p class="text-justify">
        {{ $product->description}}
    </p>
@endsection
