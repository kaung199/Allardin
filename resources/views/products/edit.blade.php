@extends('layouts.adminlayout')

@section('title')
    Products Edit
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ url('products') }}">Products</a></li>
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
        <label for="photos">Photos</label>
        <div class="form-group input-group">
            <input type="file"  value="{{ $product->photos }}" name="photos[]" class="form-control @error('photos') is-invalid @enderror" multiple>
            @if($errors->has('photos'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('photos') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'Description') }}
            {{ Form::textarea('description', null, [
                'class' => ($errors->has('description')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Product description',
                'rows' => 4
                ]) }}

            @if($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('description') }}
                    </strong>
                </span>
            @endif
        </div>
        <button class="btn btn-primary">Update</button>

	{{ Form:: close() }}

@endsection