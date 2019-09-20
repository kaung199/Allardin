@extends('layouts.adminindex')

@section('contents') 
@if($count)
    <h3><span class="badge badge-success">{{$count}}</span> Product Found</h3>
@else
    <h3>Products</h3>
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
                    <p class="card-text">Qty: {{ $product->quantity }}</p>
                    <p class="card-text">{{ $product->price }} Ks</p>
                    <a href="{{ route('cartadd', $product->id) }}" class="btn btn-primary">Add To Cart</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="text-center">{{ $products->links() }}</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>

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
