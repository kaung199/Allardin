@extends('layouts.adminlayout')

@section('title')
    Townships Create
@endsection

@section('contents') 
    <h3>Townships Create</h3>
    <hr>
    {{ Form::open([ 'route'=>'townships.store', 'method' => 'POST' ]) }}
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
            {{ Form::label(null,'Deliveryprice') }}
            {{ Form::number('deliveryprice', null, [
                'class' => ($errors->has('deliveryprice')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Deliveryprice'
                ]) }}

            @if($errors->has('deliveryprice'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('deliveryprice') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::label(null,'Delivery Man') }}
            {{ Form::text('deliveryman', null, [
                'class' => ($errors->has('deliveryman')? 'form-control is-invalid': 'form-control'),
                'placeholder' => 'Deliveryman' 
                ]) }}

            @if($errors->has('deliveryman'))
                <span class="invalid-feedback" role="alert">
                    <strong>
                        {{ $errors->first('deliveryman') }}
                    </strong>
                </span>
            @endif
        </div>

		
        <button class="btn btn-primary">Create</button>

	{{ Form:: close() }}

@endsection
