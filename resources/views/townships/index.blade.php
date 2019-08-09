@extends('layouts.adminlayout')

@section('title')
    Townships 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Townships</li>
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
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($townships as $township)
            <tr>
                <td>{{  $township->name}}</td>
                <td>{{ $township->deliveryprice }}</td>
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
            @endforeach
            
        </tbody>
        </table>
    </div>
   

@endsection
