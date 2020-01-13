@extends('layouts.adminlayout')

@section('title')
    Products Create
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ url('products') }}">Products</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('contents') 
    <h3>Products Create</h3>
    <hr>
    {{ Form::open([ 'route'=>'products.store', 'method' => 'POST','enctype' => 'multipart/form-data' ]) }}
        <div class="form-group">
            {{ Form::label(null,'Name') }}
            {{ Form::text('name', null, [
                'class' => ($errors->has('name')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Product Name'
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
            {{ Form::label(null,'Category') }}
            {{ Form::select('category_id', $category, 'null', [
                'class' => 
                ($errors->has('category_id')? 'form-control is-invalid': 'form-control'), 
            ]) }}
            @if($errors->has('category_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('category_id') }}
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
            {{ Form::number('price', null, [
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
            <input type="file" id="photos" name="photos[]" class="form-control @error('photos') is-invalid @enderror" multiple>
            @if($errors->has('photos'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('photos') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'Video') }}
            {{ Form::text('youtube', null, [
                'class' => ($errors->has('youtube')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Have Product Video?'
                ]) }}

            @if($errors->has('youtube'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('youtube') }}
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
		
        <button class="btn btn-primary">Create</button>

	{{ Form:: close() }}

@endsection
