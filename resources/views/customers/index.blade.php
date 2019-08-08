@extends('layouts.adminlayout')

@section('title')
    Customers 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Customers</li>
@endsection
@section('contents') 
    <div class="table-responsive">
        <h3>Customers</h3>
        <table class="table" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{  $user->name}}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>

                <td>
                     
                    <a class="btn btn-primary" href="{{ route('customerdetail', $user->id) }}">Detail</a>
                        
                </td>
            </tr>
            @endforeach
            
        </tbody>
        </table>
    </div>   

@endsection
