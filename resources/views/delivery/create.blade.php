@extends('layouts.adminlayout')

@section('title')
    Account Create
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Account Create</li>
@endsection
@section('contents') 
    <h3>Account Create</h3>
    <hr>
    {{ Form::open([ 'route'=>'deliveries.store', 'method' => 'POST' ]) }}
        <div class="form-group">
            {{ Form::label(null,'Name') }}
            {{ Form::text('name', null, [
                'class' => ($errors->has('name')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Delivery Name'
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
            {{ Form::label(null,'Choose Role') }}
            <select name="role" class="form-control @error('role') is-invalid @enderror">
                <option value="">Choose Role</option>
                <option value="Admin">Admin</option>
                <option value="Order">Order</option>
                <option value="Delivery">Delivery</option>
            </select>
            @error('role')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            {{ Form::label(null,'Email') }}
            {{ Form::email('email',  old('email'), [
                'class' => ($errors->has('email')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Email',
                'autocomplete' => 'email'
                ]) }}

            @if($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('email') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="new-password">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" autocomplete="new-password">
            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label(null,'Phone') }}
            {{ Form::tel('phone', null, [
                'class' => ($errors->has('phone')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Phone'
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
                'placeholder' => 'Address'
                ]) }}

            @if($errors->has('address'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('address') }}
                    </strong>
                </span>
            @endif
        </div>
		
        <button class="btn btn-primary">Create</button>

	{{ Form:: close() }}

@endsection
