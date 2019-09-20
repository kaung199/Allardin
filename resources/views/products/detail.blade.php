@extends('layouts.adminindex')

@section('contents') 
<h3>{{  $product->name }}</h3>
<hr>

<div class="row">

        <div class="col-md-4 pb-3">
            <div class="card" style="width: 18rem;">
                <a href="{{ route('productdetail', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->photos[0]->filename) }}" class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Qty: {{ $product->quantity }}</p>
                    <p class="card-text">{{ $product->price }} Ks</p>
                    <a href="{{ route('cartadd', $product->id) }}" class="btn btn-primary">Add To Cart</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h5>Description:</h5>
            <p class="text-justify">
                {{ $product->description }}
            </p>
        </div>
</div>
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
