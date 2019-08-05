@extends('layouts.adminlayout')

@section('title')
    Products 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Products</li>
@endsection
@section('contents') 
<script>
    Swal.fire({
    title: 'Error!',
    text: 'Do you want to continue',
    type: 'error',
    confirmButtonText: 'Cool'
    })
</script>
    <div class="table-responsive">
        <h3>Products</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary float-right mtc">Add Product</a>
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
            @foreach($products as $product)
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
                <!-- <td data-th="">
                    <button type="button" id="sub" class="sub update-cart" data-id="{{ $id }}">-</button>
                    <input type="number" class="quantity text-center" name="quantity" id="1" value="{{ $details['quantity']}}" min="0"/>
                    <button type="button" id="add" class="add update-cart" data-id="{{ $id }}">+</button>
                </td> -->

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
                            <a class="dropdown-item" href="{{ route('products.show', $product->id) }}">Detail</a>
                            <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Edit</a>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Product Added To Cart Successfuly',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        </script>
    
    @endif

    @if(session('outofstock'))
        <script>
            Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Product Out Of Stock!',
            })
        </script>
    
    @endif
    


@endsection
