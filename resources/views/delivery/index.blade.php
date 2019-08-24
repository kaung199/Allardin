@extends('layouts.adminlayout')

@section('title')
    Deliveries 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Deliveries</li>
@endsection
@section('contents') 
    <div class="table-responsive">
        <h3>Deliveries</h3>
        <a href="{{ route('deliveries.create') }}" class="btn btn-primary float-right mtc">Add Delivery</a>
        <table class="table table-border" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deliveries as $delivery)
            <tr>
                <td>{{  $delivery->name}}</td>
                <td>{{ $delivery->phone }}</td>

                <td>
                    {{ Form::model($delivery, [ 
                        'route'=> ['deliveries.destroy', $delivery->id], 
                        'method' => 'DELETE',
                        'onsubmit' => "return confirm('Are you sure you want to DELETE?');"
                    ]) }}
                    <a href="{{ route('deliverydetail', $delivery->id) }}" class="btn btn-info">Detail</a>
                    @if(Auth::user()->role_id == 1)
                    <button class="btn btn-danger">Delete</button>
                    @endif
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach            
        </tbody>
        </table>
    </div>

@endsection
