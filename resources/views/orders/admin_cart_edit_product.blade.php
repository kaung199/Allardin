@extends('layouts.adminindex')

@section('title')
    Products 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Order_Cart_Edit</li>
@endsection
@section('contents') 
<?php $gtotal = 0; ?>
		<div class="container pt-3 pb-5">
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
			    @foreach($orders as $details)
		    		<tr>
		    	 		<td>
                            <img src="{{asset('storage/'.$details['image'])}}" class="card-img-top" style="transition: opacity 3s ease-in-out; width: 50px;">
		    	 		</td>
		    	 		<td>{{ $details['name']}}</td>
		    			<td data-th="">
		    				<button type="button" id="{{ $details['id'] }}" class="sub update-cart-sub" data-id="{{ $details['product_id'] }}">-</button>
						    <input type="number" class="quantity text-center" name="quantity" id="{{ $details['id'] }}" value="{{ $details['quantity']}}" min="0"/>
						    <button type="button" id="{{ $details['id'] }}" class="add update-cart" data-id="{{ $details['product_id'] }}">+</button>
		    			</td>
		    			<?php 	
		    					$total = $details['quantity'] * $details['price'];
		    					$gtotal += $details['quantity'] * $details['price'];
		    			 ?>

		    			<td class="text-right">Ks {{ $total }}</td>
		    			<td>
		    				<button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $details['id'] }}"><i class="fas fa-trash-alt"></i></button>
		    			</td>
		    		</tr>
		    	@endforeach	
		    		
		    		<tr>
		    			<th colspan="3">Total</th>
		    			<th colspan="2"><strong>Ks {{ $gtotal  }}</strong></th>
		    		</tr>
		    		
			  </tbody>
			</table>
			<div class="float-right pt-3">
				<button class="btn btn-primary"><a href="{{ route('products.cart_product', $details['cart_id'] )}}" class="text-light">Add Product</a></button>
				<a href="{{  route('admin_cart_detail', $details['cart_id']) }}"><button class="btn btn-success">Update Order_Cart</button></a>
			</div>
		</div>
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
    @if(session('remove_order_cart'))
        <script>
            Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Removed Successfully!',
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
                  url: '{{ url('update_order_cart') }}',
                  method: "patch",
                  data: {

                        _token: '{{ csrf_token() }}', 
                        id: ele.attr("id"), 
                        pid: ele.attr("data-id"), 
                        quantity: ele.parents("tr").find(".quantity").val()
                    },

                  success: function (response) {
                    window.location.reload();
                    console.log(response);
                  }
               });
        });
           
           $(".update-cart-sub").click(function (e) {
              e.preventDefault(); 

              var ele = $(this);

               $.ajax({
                  url: '{{ url('update_order_cart_sub') }}',
                  method: "patch",
                  data: {

                        _token: '{{ csrf_token() }}', 
                        id: ele.attr("id"), 
                        pid: ele.attr("data-id"), 
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
                       url: '{{ route('cart.remove-from-order-cart') }}',
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
