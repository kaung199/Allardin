@extends('layouts.adminlayout')

@section('title')
    Advertise Products
@endsection

@section('head')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Advertise Products</li>
@endsection
@section('contents')
    <div class="table-responsive">
        <h3>Advertise Products</h3>
        <form role="form" method="POST" action="{{route('adv_products.store')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="validationCustom03">Products:</label>
                        <select class="form-control js-example-basic-single" name="product" id="validationCustom03" required>
                            <option value="">Choose... </option>
                            @foreach($product as $items)
                                <option value="{{$items->id}}">{{$items->name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-3">
                    <label style="color: white">Products</label><br/>
                    <button id="submit" name="submit" type="submit" class="btn btn-success">Add</button>
                </div>

            </div>
        </form>
        <table class="table" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th scope="col">Photo</th>
                <th scope="col">Code</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($adv_product as $items)
                <tr>
                    <td>
                        @foreach($items->photos as $photo)
                            <img src="{{ asset('storage/' . $photo->filename) }}" alt="" style="width:50px; height:50px;">
                        @endforeach
                    </td>
                    <td>{{$items->code}}</td>
                    <td>{{$items->name}}</td>
                    <td>{{$items->quantity}}</td>
                    <td>{{$items->price}}</td>
                    <td>
                        <form action="{{ route('adv_products.destroy', $items->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();
        });
    </script>
@endsection