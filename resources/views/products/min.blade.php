@extends('layouts.adminlayout')

@section('title')
    Products 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Products Min</li>
@endsection
@section('contents') 
<form action="{{ route('product-min-search') }}" method="GET">
    @csrf
    <div class="o">
        <input type="number" name="qty" required>
        <button>search </button>
    </div>
</form>
@if(isset($products))
<div class="table-responsive">
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
        @foreach($products as $product)
        <tr>
            <td>
                @foreach($product->photos as $photo) 
                    <img src="{{ asset('storage/' . $photo->filename) }}" alt="" style="width:50px; height:50px;">
                @endforeach
            </td>
            <td>{{  $product->code}}</td>
            <td>{{  $product->name}}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->price }}</td>
            
            <td>
                {{ Form::model($product, [ 
                    'route'=> ['products.destroy', $product->id], 
                    'method' => 'DELETE',
                    'onsubmit' => "return confirm('Are you sure you want to DELETE?');"
                ]) }}
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('products.show', $product->id) }}">Detail</a>
                        <?php $page = $products->currentPage(); ?>
                        @if(Auth::user()->role_id == 1)
                            <a class="dropdown-item" href="{{ route('editproduct', ['id' => $product->id,'page' => $page ]) }}" >Edit</a>
                            <button class="dropdown-item">Delete</button>
                        @endif
                    </div>
                </div>
                    
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach            
    </tbody>
    </table>
</div>
<div class="text-center">{{ $products->appends(Request::only('qty'))->links() }}</div>
@endif
   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    <script>
        @if(session('success'))        
                Swal.fire({
                    title: 'Product Added To Cart Successfuly',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })      
        @endif

        // function myFunction() {
        //     var input, filter, table, tr, td, i, txtValue;
        //     input = document.getElementById("myInput");
        //     filter = input.value.toUpperCase();
        //     table = document.getElementById("myTable");
        //     tr = table.getElementsByTagName("tr");
        //     for (i = 0; i < tr.length; i++) {
        //         td = tr[i].getElementsByTagName("td")[0];
        //         if (td) {
        //         txtValue = td.textContent || td.innerText;
        //         if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //             tr[i].style.display = "";
        //         } else {
        //             tr[i].style.display = "none";
        //         }
        //         }       
        //     }
        // }
    
    </script>

@endsection
