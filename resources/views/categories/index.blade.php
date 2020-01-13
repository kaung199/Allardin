@extends('layouts.adminlayout')

@section('title')
    Products Create
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('contents') 
<div class="row">
    <div class="col-md-3">
        <h3>Category Create</h3>
        <hr>
        <form role="form" method="POST" action="{{route('category_store')}}">
            @csrf
            <div class="form-group">
                <label>Code</label>
                @if(isset($code))
                    <input type="text" class="form-control" name="code" id="code" value="{{"00".$code}}" readonly>
                @else
                    <input type="text" class="form-control" name="code" id="code" value="{{"001"}}" readonly>
                @endif
            </div>
            <div class="form-group">
                <label>Name</label>
                <div>
                    <input type="text" class="form-control" name="name" placeholder="Enter Name" required autofocus>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
            <a href="{{route('category')}}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
    <div class="col-md-9">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1 ?>
            @foreach($category as $key => $categories)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$categories->code}}</td>
                    <td>{{$categories->name}}</td>
                    <td>
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('category_edit',$categories->id) }}" class="btn btn-primary  fa fa-edit"></a>
                            </div>
                            <div class="col-md-2">
                                <form action="{{ route('category_delete', $categories->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete?')">Del</button>
                                </form>
                            </div>
                        </div>                        
                    </td>
                </tr>
                <?php $i++ ?>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    

@endsection
