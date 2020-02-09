
@extends('layouts.adminindex')

@section('title')
    Orders Prepare
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"> <a href="{{ url('order') }}">Order</a></li>
    <li class="breadcrumb-item active">Order Prepare</li>
@endsection
@section('contents')

<div class="pt-5 pb-5">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fa fa-barcode"></i></span>
        </div>
        <input type="text" class="form-control" id="productcode" placeholder="Please Scan the Barcode (or) Type Product Code" aria-label="Please Scan the Barcode (or) Type Product Code" aria-describedby="basic-addon1" onblur="this.focus()" style="outline:none;border-color:none;box-shadow:none;"autofocus/>
    </div>
    <br>
    <div class="printposition table-responsive shadow p-5">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Product Name</th>
              <th scope="col">Qty</th>
              <th scope="col">Checked</th>
              <th scope="col">Status</th>
    
            </tr>
          </thead>
            <input type="hidden" value="{{ $orderdetails[0]->order_id }}" id="order_id">
          <tbody>
              @php
                  $total = 0;
                  $totalC = 0;
              @endphp
                @foreach($orderdetails as $orderdetail) 
                @php
                    $total += $orderdetail->quantity;
                    $totalC += $orderdetail->check;
                @endphp
                    <tr>
                        <td>{{ $orderdetail->name }}</td>
                        <td id="qty{{$orderdetail->code}}">{{ $orderdetail->quantity }}</td>
                        <td id="{{$orderdetail->code}}">{{ $orderdetail->check }}</td> 
                    <td><span class="text-danger cross" id="cross{{$orderdetail->code}}">&#10540;</span><span class="text-success markk">&#10004;</span><span class="text-success htmlmark{{$orderdetail->code}}"></span></td>
                    </tr>
                @endforeach  
                <input type="hidden" value="{{ $total }}" id="total" >
                <input type="hidden" value="{{$totalC }}" id="totalC">
          </tbody>
        </table>
        <div class="pt-3">
            <button class="btn btn-danger" id="cancel">Cancel</button>
            <button type="button" class="btn btn-danger" id="recheck">
                Recheck
            </button>
            <button type="button" class="btn btn-success" id="confirm">
                Confirm
            </button>
        </div> 
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    $('#confirm').hide();
    $('#recheck').hide();
    $('.markk').hide();

    if($('#total').val() == $('#totalC').val()) {
        $('#confirm').show();
        $('#recheck').show();

        $('.markk').show();
        $('#cancel').hide();
        $('.cross').hide();
    }

    $("#productcode").keyup(function(e){
        if(e.keyCode == 13)
        {
            var productcode = $('#productcode').val();
            var order_id = $('#order_id').val();
            $.get("{{ route('o_p_barcode') }}",
                {
                    code: productcode,
                    id: order_id
                },
                function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    var json = $.parseJSON(data);
                    // alert(json);                      
                    if(json.msg=="")
                    { 
                        var qty = Number($("#qty"+json.p_code).html());
                        var checked =  Number($("#"+json.p_code).html()); 
                        
                        if(qty > checked) {
                            checked += 1;
                            $("#"+json.p_code).html(checked);
                            var totalC = Number($('#totalC').val());
                            totalC += 1;
                            $('#totalC').val(totalC);

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Success',
                                animation: false,
                                showConfirmButton: false,
                                timer: 400
                            });

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Already Checked!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                        if(qty === checked) {
                            $('.htmlmark'+json.p_code).html('&#10004;');
                            $('#cross'+json.p_code).hide();
                        }
                        $('#productcode').val("");
                        $('#productcode').focus();
                        if($('#total').val() == $('#totalC').val()) {
                            $('#cancel').hide();
                            $('#confirm').show();
                            $('.cross').hide();
                            $('#recheck').show();

                        }

                    }
                    else
                    {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: json.msg,
                            showConfirmButton: false,
                            timer: 1000
                        });

                        $('#productcode').val("");
                        $('#productcode').focus();

                        if($('#total').val() == $('#totalC').val()) {
                            $('#confirm').show();
                            $('#recheck').show();
                        }
                    }
                });
        }
    });
   
    $("#cancel,#recheck").click(function(){

        var order_id = $('#order_id').val();
        $.get("{{ route('o_p_cancel') }}",
            {
                id: order_id
            },
            function(data, status){
                // alert("Data: " + data + "\nStatus: " + status);
                var json = $.parseJSON(data);
                // alert(json);                      
                if(json.msg=="")
                { 
                    location.reload(true);
                }
                else
                {
                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: json.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    
                    $('#productcode').val("");
                    $('#productcode').focus();
                }
            });
        
    });
    $("#confirm").click(function(){
        var order_id = $('#order_id').val();
        $.get("{{ route('o_p_confirm') }}",
            {
                id: order_id
            },
            function(data, status){
                // alert("Data: " + data + "\nStatus: " + status);
                var json = $.parseJSON(data);
                // alert(json);                      
                if(json.msg=="")
                { 
                    window.history.back();
                }
                else
                {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: json.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        );
    });
</script>
@endsection
