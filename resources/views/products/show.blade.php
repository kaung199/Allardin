@extends('layouts.adminlayout')

@section('title')
    Products 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Products</li>
    <li class="breadcrumb-item active">Detail</li>
@endsection
@section('contents') 
    <h3>Products</h3>
    <hr>
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Photo</th>
        <th scope="col">Name</th>
        <th scope="col">Quantity</th>
        <th scope="col">Price</th>
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
            <td>
                
                {{ Form::model($product, [ 
                    'route'=> ['products.destroy', $product->id], 
                    'method' => 'DELETE',
                    'onsubmit' => "return confirm('Are you sure you want to DELETE?');"
                ]) }}
                    <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                    <button class="btn btn-danger">Delete</button>
                {{ Form::close() }}
            </td>
        </tr>
        
    </tbody>
    </table>
    <hr>
    <h4>Description</h4>
    <p>
        {{ $product->description}}
    </p>
@endsection
