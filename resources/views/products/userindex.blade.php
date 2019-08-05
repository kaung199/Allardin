@extends('layouts.firstlayout')

@section('title')
    Home
@endsection

@section('contents')
    @foreach($products as $product)
        <div class="col_1_of_3 span_1_of_3"> 
            <div class="view view-first">
                <a href="#">
                <div class="inner_content clearfix">
                    <div class="product_image">
                            <img src="{{ asset('storage/' . $product->photos[0][filename] ) }}" class="img-responsive" alt=""/>
                        <div class="mask">
                            <div class="info">Quick View</div>
                        </div>
                        <div class="product_container">
                            <div class="cart-left">
                                <p class="title">{{ $product->name }}</p>
                            </div>
                            <div class="price">{{ $product->price }} Ks</div>
                            <div class="clearfix"></div>
                        </div>		
                    </div>
                    <div class="sale-box">
                        <span class="on_sale title_shop">New</span>
                    </div>	
                </div>
                </a>
            </div>
        </div>
    @endforeach
@endsection