@extends('layouts.adminindex')

@section('contents') 

<h3><span class="badge badge-success">{{$count}}</span> Product Found</h3>
<hr>
@foreach($products as $product)
    <ul>
        <a href="{{ route('productdetail', $product->id) }}">
            <li>{{ $product->name }} => {{ $product->price }}Ks</li>
        </a>            
    </ul>
@endforeach
@endsection
