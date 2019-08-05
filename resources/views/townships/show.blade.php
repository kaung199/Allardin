@extends('layouts.adminlayout')

@section('title')
    Township 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('townships.index') }}">Township</a></li>
    <li class="breadcrumb-item active">{{ $township->name }}</li>
@endsection
@section('contents') 
<div class="table-responsive">
    <h3>Townships</h3>
    <a href="{{ route('townships.create') }}" class="btn btn-primary mtc float-right">Add Township</a>
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Delivery Price</th>
        <th scope="col">Delivery Man</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{  $township->name }}</td>
            <td>{{ $township->deliveryprice }}</td>
            <td>{{ $township->deliveryman }}</td>
            <td>
                
                {{ Form::model($township, [ 
                    'route'=> ['townships.destroy', $township->id], 
                    'method' => 'DELETE',
                    'onsubmit' => "return confirm('Are you sure you want to DELETE?');"
                ]) }}
                    <a class="btn btn-primary" href="{{ route('townships.edit', $township->id) }}">Edit</a>
                    <button class="btn btn-danger">Delete</button>
                {{ Form::close() }}
            </td>
        </tr>        
    </tbody>
    </table>
</div>
@endsection
