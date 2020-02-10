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
        @if(session('order_cart'))
        <a href="{{ route('orders.order_cart_editp', session('order_cart')) }}" class="btn btn-warning">Back To Edit</a>
        @else
        <h3>Products</h3>
        @endif
        <hr>
        <table class="table" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th scope="col">Photo</th>
            <th scope="col">Code</th>
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
                <td>{{  $product->code}}</td>
                <td>{{  $product->name}}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->price }}</td>
                @if(session('order_cart'))
                <td> <a href="{{ route('cartadd_cart_order', [ $product->id,session('order_cart') ] ) }}" class="btn btn-warning addtocart"><i class="fas fa-cart-plus"></i>Add Cart_Order</a></td>    
                @else            
                <td> <a href="{{ route('cartadd', $product->id) }}" class="btn btn-primary addtocart"><i class="fas fa-cart-plus"></i>Add Cart_Order</a></td>    
                @endif
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
                            @if(Auth::user()->role_id == 1)
                                <button class="dropdown-item">Delete</button>
                            @endif
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    <script>
        @if(session('success'))        
                Swal.fire({
                    title: 'Product Added To Cart Successfuly',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })      
        @endif

        @if(session('outofstock'))
                Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Product Out Of Stock!',
                })    
        @endif
        @if(session('permission'))
                Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Permission Denined !!!Ask Admin!!!',
                })    
        @endif
    
    </script>
@endsection
