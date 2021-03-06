@extends('layouts.firstlayout')

@section('title')
    Product Detail
@endsection

@section('contents')
<div class="g">
    <div class="dreamcrub">
        <ul class="breadcrumbs">
        <li class="home">
            <a href="{{ url('/') }}" title="Go to Home Page">Home</a>&nbsp;
            <span>&gt;</span>
        </li>
        <li class="women text1line">&nbsp;
            {{ $product->name }}&nbsp;
        </li>
    </ul>
    <ul class="previous">
        <li><a href="{{ url('/') }}">Back to Previous Page</a></li>
    </ul>
    <div class="clearfix"></div>
    </div>
    <div class="singel_right">
        <div class="labout span_1_of_a1">
    <!-- start product_slider -->
            <ul id="etalage">
            @if($product->photos[0][filename]) 
                @foreach($product->photos as $photo)
                    <li>
                        <img class="etalage_thumb_image" src="{{ asset('storage/' . $photo[filename] ) }}" class="img-responsive" />
                        <img class="etalage_source_image" src="{{ asset('storage/' . $photo[filename] ) }}" class="img-responsive" />
                    </li>
                @endforeach
            @else 
                <li>
                    <img class="etalage_thumb_image" src="{{ asset('/ui/images/350400.jpg') }}" class="img-responsive" />
                    <img class="etalage_source_image" src="{{ asset('/ui/images/350400.jpg') }}" class="img-responsive" />
                </li>
            @endif
            </ul>
        <!-- end product_slider -->
    </div>
    <div class="cont1 span_2_of_a1">
    <h1>{{  $product->name }}</h1>
    <div class="price_single">
        <span class="actual">{{ $product->price }} Ks</span>
    </div>    
    <ul class="product-qty">
        <span>Quantity:</span>
        <select>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
        </select>
    </ul>
    <div class="btn_form">
        <form>
            <input type="submit" value="Add to Cart" title="" disabled>
        </form>
    </div>
    <h2 class="quick">Description:</h2>
    <p class="quick_desc">
        {{ $product->description }}
    </p>
</div>
<div class="clearfix"></div>
</div>
@endsection
@section('youtube')
    @if($product->youtube != null)
    <div class="youtube">
        <iframe width="560" height="315" src="https://youtube.com/embed/{{ $product->youtube }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    @endif
@endsection