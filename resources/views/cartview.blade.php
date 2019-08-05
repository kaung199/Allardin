@extends('layouts.adminlayout')

@section('title')
    Products 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Cart</li>
@endsection
@section('contents') 

<?php $gtotal = 0; ?>
	@if(session('cart'))
		<div class="container pt-3 mb-9">
			<table class="table table-bordered text-center">
			   <thead>
			    <tr>
			      <th scope="col">Image</th>
			      <th scope="col">Name</th>
			      <th scope="col">Qty</th>
			      <th scope="col">Price</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			    @foreach(session('cart') as $id => $details)
		    		<tr>
		    	 		<td>
                            <img src="{{asset('storage/'.$details['image'])}}" class="card-img-top" style="transition: opacity 3s ease-in-out; width: 50px;">
		    	 		</td>
		    	 		<td>{{ $details['name']}}</td>
		    			<td data-th="">
		    				<button type="button" id="{{ $details['id'] }}" class="sub update-cart-sub" data-id="{{ $id }}">-</button>
						    <input type="number" class="quantity text-center" name="quantity" id="{{ $details['id'] }}" value="{{ $details['quantity']}}" min="0"/>
						    <button type="button" id="{{ $details['id'] }}" class="add update-cart" data-id="{{ $id }}">+</button>
		    			</td>
		    			<?php 	
		    					$total = $details['quantity'] * $details['price'];
		    					$gtotal += $details['quantity'] * $details['price'];
		    			 ?>

		    			<td class="text-right">Ks {{ $total }}</td>
		    			<td>
		    				<button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fas fa-trash-alt"></i></button>
		    			</td>
		    		</tr>
		    	@endforeach	
		    		
		    		<tr>
		    			<th colspan="3">Total</th>
		    			<th colspan="2"><strong>Ks {{ $gtotal  }}</strong></th>
		    		</tr>
		    		
			  </tbody>
			</table>
			<div class="float-right">
				<button class="btn btn-primary"><a href="{{ route('products.index')}}" class="text-light">Add Product</a></button>
				<button class="btn btn-danger"><a href="{{ route('cart.alldelete')}}" OnClick="return confirm('Are You Sure to Delete All');" class="text-light">Empty Cart</a></button>
				<a href="{{ route('checkoutform') }}"><button class="btn btn-success">Check Out</button></a>
			</div>
		</div>
	@else
	<div class="container text-center shadow p-5 mb-5">
		<h1 class="text-danger">Your Cart is Empty</h1>
		<button class="btn btn-success"><a href="{{ url('/products') }}" class="text-light">Continute Shopping</a></button>
	</div>
	@endif
	
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>	
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	@if(session('outofstock'))
        <script>
            Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Product Out Of Stock!',
            })
        </script>
    
    @endif
	<script type="text/javascript">

		$('.add').click(function () {
				if ($(this).prev().val()) {
		    	$(this).prev().val(+$(this).prev().val() + 1);
				}
		});
		$('.sub').click(function () {

				if ($(this).next().val() > 1) {
		    	if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
				} 
		});

        $(".update-cart").click(function (e) {
              e.preventDefault(); 

              var ele = $(this);

               $.ajax({
                  url: '{{ url('update-cart') }}',
                  method: "patch",
                  data: {

                        _token: '{{ csrf_token() }}', 
                        id: ele.attr("data-id"), 
                        pid: ele.attr("id"), 
                        quantity: ele.parents("tr").find(".quantity").val()},

                  success: function (response) {
                      window.location.reload();
                  }
               });
		   });
		   
		   $(".update-cart-sub").click(function (e) {
              e.preventDefault(); 

              var ele = $(this);

               $.ajax({
                  url: '{{ url('update-cart-sub') }}',
                  method: "patch",
                  data: {

                        _token: '{{ csrf_token() }}', 
                        id: ele.attr("data-id"), 
                        pid: ele.attr("id"), 
                        quantity: ele.parents("tr").find(".quantity").val()},

                  success: function (response) {
                      window.location.reload();
                  }
               });
           });

           $(".remove-from-cart").click(function (e) {
               e.preventDefault();

               var ele = $(this);

               if(confirm("Are you sure to Remove")) {
                   $.ajax({
                       url: '{{ route('cart.remove-from-cart') }}',
                       method: "DELETE",
                       data: {_token: '{{ csrf_token() }}', 
                       id: ele.attr("data-id")},
                       success: function (response) {
                           window.location.reload();
                       }
                   });
               }
           });


	</script>



@endsection
