@extends('layouts.adminlayout')

@section('title')
    Products 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Products</li>
@endsection
@section('contents') 
    <h3>Products</h3>
    <a href="{{ route('products.create') }}" class="btn btn-primary float-right mtc">Add Product</a>
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
            <td>
                {{ Form::model($product, [ 
                    'route'=> ['products.destroy', $product->id], 
                    'method' => 'DELETE',
                    'onsubmit' => "return confirm('Are you sure you want to DELETE?');"
                ]) }}
                    <a class="btn btn-success" href="{{ route('products.show', $product->id) }}">Detail</a>
                    <a class="btn btn-secondary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                    <button class="btn btn-danger">Delete</button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
        
    </tbody>
    </table>

@endsection
