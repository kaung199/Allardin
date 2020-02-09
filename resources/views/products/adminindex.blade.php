@extends('layouts.adminindex')

@section('contents') 
@if($count)
    <h3><span class="badge badge-success">{{$count}}</span> Product Found</h3>
@else
        @if(session('order_cart'))
            <a href="{{ route('orders.order_cart_editp', session('order_cart')) }}" class="btn btn-warning">Back To Edit</a>
        @else
            <h3>Products</h3>
        @endif
@endif
<div class="row">
    @foreach($products as $product)
        <div class="col-md-4 pb-3">
            <div class="card" style="width: 18rem;">
                <a href="{{ route('productdetail', $product->id) }}">
                @if($product->photos[0][filename])
                    <img src="{{ asset('storage/' . $product->photos[0]->filename) }}" class="card-img-top" alt="...">
                @else
                <img src="{{ asset('/ui/images/350400.jpg') }}" class="card-img-top" alt=""/>
                @endif
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Code: {{ $product->code }}</p>
                    <p class="card-text">Qty: {{ $product->quantity }}</p>
                    <p class="card-text">{{ $product->price }} Ks</p>
                    @if(session('order_cart'))
                    <a href="{{ route('cartadd_cart_order', [ $product->id, session('order_cart') ] ) }}" class="btn btn-warning addtocart"><i class="fas fa-cart-plus"></i>Add Cart_Order</a>   
                    @else            
                    <a href="{{ route('cartadd', $product->id) }}" class="btn btn-primary">Add To Cart</a>    
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="text-center table-responsive">{{ $products->links() }}</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
<script>
    @if(session('deliverystatus'))        
            Swal.fire({
                title: 'Delivery Status Updated Successfuly',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })    
    @endif
    @if(session('success'))        
            Swal.fire({
                title: 'Product Added To Cart Successfuly',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })      
    @endif

    @if(session('permission'))
            Swal.fire({
                title: 'Permission Access Deny !!Ask Admin!!',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })   
    @endif

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
</script>

@endsection
