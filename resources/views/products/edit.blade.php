@extends('layouts.adminlayout')

@section('title')
    Products Edit
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Products</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('contents') 
    <h3>Products Edit</h3>
    <hr>
    {{ Form::model($product, [ 
        'route'=> ['products.update', $product->id],
         'method' => 'PUT','enctype' => 'multipart/form-data' ]) }}
        <div class="form-group">
            {{ Form::label(null,'Name') }}
            {{ Form::text('name', null, [
                'class' => ($errors->has('name')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Township Name'
                ]) }}

            @if($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('name') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'Quantity') }}
            {{ Form::number('quantity', null, [
                'class' => ($errors->has('quantity')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Enter Quanties'
                ]) }}

            @if($errors->has('quantity'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('quantity') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'Price') }}
            {{ Form::text('price', null, [
                'class' => ($errors->has('price')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Enter price' 
                ]) }}

            @if($errors->has('price'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('price') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'Photo') }}
            {{ Form::file('photo', null, [
                'class' => ($errors->has('photo')? 'form-control is-invalid': 'form-control') 
                ]) }}

            @if($errors->has('photo'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('photo') }}
                    </strong>
                </span>
            @endif
        </div>
		
        <button class="btn btn-primary">Update</button>

	{{ Form:: close() }}

@endsection
