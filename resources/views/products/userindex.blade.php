@extends('layouts.firstlayout')

@section('title')
    Home
@endsection

@section('contents')


@if($products[0])
    @if($count)
        <h3 class="m_1 pdl"> ( {{$count}} ) Products Found</h3>
    @else
        <h3 class="m_1 pdl">Products</h3>    
    @endif
    @foreach($products as $product)
        <div class="col_1_of_3 span_1_of_3"> 
            <div class="view view-first">
                <a href="{{ url('detail', $product->id) }}">
                <div class="inner_content clearfix">
                    <div class="product_image">
                        @if($product->photos[0][filename]) 
                            <img src="{{ asset('storage/' . $product->photos[0][filename] ) }}" class="img-responsive" alt=""/>
                        @else
                            <img src="{{ asset('/ui/images/350400.jpg') }}" class="img-responsive" alt=""/>
                        @endif
                        <div class="mask">
                            <div class="info">Quick View</div>
                        </div>
                        <div class="product_container">
                            <div class="cart-left">
                                <p class="title">{{ $product->name }}</p>
                            </div>
                            <div class="price">{{ $product->price }} Ks</div>                             
                        </div>		
                    </div>	
                </div>
                </a>
            </div>
        </div>
    @endforeach
@else
<h3 class="m_1 pdl"> No Products Found</h3> 
<div class="text-center">
    <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>  
</div> 
@endif
    
@endsection