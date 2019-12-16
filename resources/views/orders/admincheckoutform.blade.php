@extends('layouts.adminlayout')

@section('title')
    Customer Create
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Customer</li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('contents') 
    <h3>Customer Create</h3>
    <hr>
    {{ Form::open([ 'route'=>'cart_checkout', 'method' => 'POST' ]) }}
        <div class="form-group">
            {{ Form::label(null,'Name') }}
            {{ Form::text('name', null, [
                'class' => ($errors->has('name')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Customer Name'
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
            {{ Form::label(null,'Phone') }}
            {{ Form::tel('phone', null, [
                'class' => ($errors->has('phone')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Enter Phone No'
                ]) }}

            @if($errors->has('phone'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('phone') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'Address') }}
            {{ Form::text('address', null, [
                'class' => ($errors->has('address')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Enter address' 
                ]) }}

            @if($errors->has('address'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('address') }}
                    </strong>
                </span>
            @endif
        </div>
        
        <div class="form-group">
            {{ Form::label(null,'Townships') }}
            {{ Form::select('township_id', $townships, 'null', [
                'class' => 
                ($errors->has('township_id')? 'form-control is-invalid': 'form-control'), 
            ]) }}
            @if($errors->has('township_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('township_id') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'Discount') }}
            {{ Form::number('discount', null, [
                'class' => ($errors->has('discount')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Have discount?' 
                ]) }}

            @if($errors->has('discount'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('discount') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'DeliveryDate') }}
            <input type="date" name="delivery_date" data-date-inline-picker="true" style="box-shadow: none;"  class="form-control" aria-label="Search" aria-describedby="basic-addon2" required="required">
            
        </div>
        <div class="form-group">
            {{ Form::label(null,'Remark') }}
            {{ Form::textarea('remark', null, ['placeholder' => 'Have Remark?', 'class' => 'form-control', 'rows' => '3']) }}
        </div>

		
        <button class="btn btn-primary" OnClick="return confirm('Are You Sure to Order');">Order</button>

	{{ Form:: close() }}

@endsection
