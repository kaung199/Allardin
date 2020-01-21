<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Voucher</title>
</head>
<body>
    <div class="float-left">
    <a href="{{ route('login') }}" class="btn btn-primary" style="border-top-left-radius: 100px 60px; border-bottom-left-radius: 100px 60px;"><span class="text-danger" style="font-size: 18px;">&#8619;</span> Back Home</a>
    </div>
    <div class="container pt-5 pb-5">
        <h2 class="text-center font-weight-bold">Voucher</h2>

        <input type="text" class="form-control" id="voucher_search"  style="width: 100%" name="order_id" placeholder="Enteer Voucher No." onblur="this.focus()" autofocus />

        <br><br>
        @if(is_array($session_data))
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order_id</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Delivery</th>
                    <th scope="col">Delivery Date</th>
                    <th scope="col" class="text-left">Qty</th>
                    <th scope="col" class="text-left">Price</th>
                </tr>
                </thead>
                @php
                    $i = 0;
                @endphp
                    <tbody id="sales_table">
                        
                        
                            @foreach($session_data as $key => $value)
                            @php
                                $i++;
                                $total += $value['grand_total'];
                            @endphp
                                <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $value['order_id'] }}</td>
                                <td>{{ $value['cus_name'] }}</td>
                                <td>{{ $value['d_name'] }}</td>
                                <td>{{ $value['d_date'] }}</td>
                                <td class="text-left">{{ $value['total_qty'] }}</td>
                                <td class="text-left">{{ $value['grand_total'] }}</td>

                                    
                                </tr>
                            @endforeach
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" colspan="6" class="text-center pt-3"><h5>Grand Total</h5></th>
                                <th scope="col" class="pt-3 text-left"><h5 id="grand_total">{{ $total }}</h5></th>
                                </tr>
                            </thead>

                    </tbody>
            </table>
            <br>
            <div class="float-right">
                <button class="btn btn-danger" id="alldelete" onclick="return confirm('Are you sure to cancel?')">Cancel</button>
                &nbsp;
                <button class="btn btn-success" id="confirm" onclick="return confirm('Are you sure to submit?')">Confirm</button>
            </div>
        @endif
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script>
        //PageLoad
        $.get("{{ route('voucher_data') }}",
            function(data, status){
                // alert("Data: " + data + "\nStatus: " + status);
                var json = $.parseJSON(data);
                // alert(json);
                if(json.msg=="")
                {
                    $("#sales_table").html();
                    var html = "";
                    var gt = $('#grand_total').html();
                
                    $.each(json.sales_table,function(index,value){
                        //alert(value['code']);
                        var count = value['count'] + 1;
                        var order_id = value['order_id'];
                        var total_qty = value['total_qty'];
                        var d_name = value['d_name'];
                        var cus_name = value['cus_name'];
                        var d_date = value['d_date'];
                        var grand_total = value['grand_total'];
                        var integer = Number(gt);
                        var sum = integer + grand_total;
                        $('#grand_total').html(sum);
                        html += '<tr><td>'+count+'</td><td>'+order_id+'</td><td>'+cus_name+'</td><td>'+d_name+'</td><td>'+d_date+'</td><td>'+total_qty+'</td><td>'+grand_total+'</td></tr>';
                    });
                    $("#sales_table").html(html);
                    $('#voucher_search').val("");
                    $('#voucher_search').focus();
                }
                else
                {
                    $('#voucher_search').val("");
                    $('#voucher_search').focus();
                    swal({
                        title: "",
                        text: json.msg,
                        type: "success"
                    });
                }
        });
        //add to list
        $("#voucher_search").keyup(function(e){
            if(e.keyCode == 13)
            {
                var voucher_search = $('#voucher_search').val();
                $.get("{{ route('voucher_search') }}",
                    {
                        order_id: voucher_search
                    },
                    function(data, status){
                        // alert("Data: " + data + "\nStatus: " + status);
                        var json = $.parseJSON(data);
                        // alert(json.count);                      
                        if(json.msg=="")
                        {
                            $("#sales_table").html();
                            var html = "";
                            var gt = $('#grand_total').html();
                            
                            $.each(json.sales_table,function(index,value){
                                //alert(value['code']);
                                var count = value['count'] + 1;
                                var order_id = value['order_id'];
                                var total_qty = value['total_qty'];
                                var d_name = value['d_name'];
                                var cus_name = value['cus_name'];
                                var d_date = value['d_date'];
                                var grand_total = value['grand_total'];
                                var integer = Number(gt);
                                var sum = integer + grand_total;
                                $('#grand_total').html(sum);
                                html += '<tr><td>'+count+'</td><td>'+order_id+'</td><td>'+cus_name+'</td><td>'+d_name+'</td><td>'+d_date+'</td><td>'+total_qty+'</td><td>'+grand_total+'</td></tr>';
                            });
                            $("#sales_table").html(html);
                            $('#voucher_search').val("");
                            $('#voucher_search').focus();
                        }
                        else
                        {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Oops...',
                                text: json.msg,
                                type: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#voucher_search').val("");
                            $('#voucher_search').focus();
                        }
                    });
            }
        });

        //alldelete session
        $('#alldelete').on('click', function(){
            $.get("{{ route('voucher_cancel') }}",
                function(data, status){
                    var json = $.parseJSON(data);
                    if(json.msg)
                    {
                        $('#grand_total').html("");
                        $("#sales_table").html("");
                        $('#voucher_search').val("");
                        $('#voucher_search').focus();
                        Swal.fire({
                            title: "",
                            position: 'top-end',
                            icon: 'success',
                            text: json.msg,
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                });
        });
        //confirm
        $('#confirm').on('click', function(){
            $.get("{{ route('voucher_confirm') }}",
                function(data, status){
                    var json = $.parseJSON(data);
                    if(json.msg)
                    {
                        $('#grand_total').html("");
                        $("#sales_table").html("");
                        $('#voucher_search').val("");
                        $('#voucher_search').focus();
                        Swal.fire({
                            title: "",
                            position: 'top-end',
                            icon: 'success',
                            text: json.msg,
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                });
        });
    </script>
</body>
</html>