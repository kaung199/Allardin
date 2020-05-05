@extends('layouts.pos')

@section('contents')
<div class="form-group">
    {{ Form::select('product_id', $product, 'null', [
        'class' => 'form-control selectpicker border', 
        'data-live-search' => "true",
        'id' => "product_name",
        'aria-describedby' => "basic-addon2",
        'style' => "text-decoration:none;"
    ]) }}
    {{-- <button>Search</button> --}}

</div>

<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01"><i class="fa fa-barcode"></i></span>
          </div>
        <input type="text" class="form-control" id="productcode" placeholder="Please Scan the Barcode & Product Name" autofocus/>
    </div>

</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if ($message = session('price_error'))
<div class="alert alert-danger">
    <p>{{ $message }}</p>
</div>
@endif
<br>
<table class="table table-bordered table-hover">
    <thead class="thead-light">
        <tr>
            <th>Code</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="sales_table">

    @if(is_array($session_data))
        @foreach($session_data as $key => $value)
            <tr class="{{ $value['product_id'] }}">

                @foreach($value as $k => $v)
                    <td>{{$v}}</td> 
                @endforeach

                <td>
                    <a class="btn btn-danger" id="{{ $value['product_id'] }}" data-rowid="{{ $value['product_id'] }}" data-toggle="modal" data-target="#myModalDelete"><i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    @endif

    </tbody>
</table>
<br><br>
<div class="row">
    <div class="col-md-12">
        <div class="float-right" style="width:500px;">
        <form action="{{url('sales/confirm')}}" method="POST">
                @csrf 
                <div class="row">
                    <label for="grand_total" class="col-md-4">Grand-Total:</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class='form-control' name="grand_total" id="grand_total" required="required" readonly/>
                            <span class="input-group-addon pt-2">Ks</span>
                        </div>
                    </div><!--GrandTotal -->
                </div><br/>
            
                <div class="row">
                    <label for="paid" class="col-md-4">Paid:</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="number" class="form-control" value="0" name="paid" id="paid" required/>
                            <span class="input-group-addon pt-2">Ks</span>
                        </div>
                    </div><!--Paid -->
                </div><br/>
            
                <div class="row">
                    <label for="change_amount" class="col-md-4">Return Change:</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class='form-control' name="change_amount" id="change_amount" value="0" readonly>
                            <span class="input-group-addon pt-2">Ks</span>
                        </div>
                    </div><!--Return -->
                </div><br/>
            
                {{-- <div class="row">
                    <label for="discount" class="col-sm-offset-6 col-sm-2 control-label">Discount:</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class='form-control' name="discount" id="discount" value="0">
                            <span class="input-group-addon">Ks</span>
                        </div>
                    </div><!--Discount -->
                </div><br/> --}}
                {{-- <div class="row">
                    <label for="township" class="col-sm-offset-6 col-sm-2 control-label">Townships:</label>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control selectpicker" data-live-search="true" name="township_id" id="township" required>
                                @foreach($townships as $town)
                                <option value="{{ $town->id }}">
                                    {{ $town->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--townships -->
                </div> --}}

                <br/>
                <div class="row folat-right" style="right:26px;position:absolute">
                    <div class="demo-jasmine-btn panel-body col-md-offset-9">
                        <a href="#" class="btn btn-danger" id="allremove" onclick="return confirm('Are you sure to remove?')"><span class="fa fa-remove"></span> Cancel</a>
                        <!-- <button class="btn btn-pink" id="confirm"><span class="fa fa-check"></span> Confirm Sales</button> -->
                        <button class="btn btn-success"><span class="fa fa-check"></span>Confirm Sales</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="printarea">
    @if(isset($sale))
        <h3 class="text-center">" <u>KITCHEN VENUS</u> "</h3>
        <p class="text-center">
            No. 262 (Ground Floor), Bagaya Road, Sanchaung Township
        </p>
        <p class="text-center">
            Myaynigone ,Yangon
        </p>
        <p class="text-center">09-661956600</p>
        <br>
        @php
            $now = now();
        @endphp
        <table class="table">
            <tr class="text-center">
                <td><p><b>Date::</b> {{ $now }}</p></td>
                <td><p><b>Bill No::</b> {{ $sale->invoice_no }}</p></td>
            </tr>
        </table>
        
        
        

        <table class="table table-bordered">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Qty</th>
            <th scope="col">Price</th>
            <th scope="col">Totalprice</th>
            </tr>
        </thead>
        <tbody>
        @foreach($saleDetail as $d)
        
        <tr>
            <td>{{  $d->product->name }}</td>
            <td>{{  $d->tqty }}</td>
            <td>{{  $d->product->price }}</td>
            <td>{{  $d->tp }}.00</td>
        </tr>
        @endforeach
            <tr>
                <td colspan="3" class="text-center"><h4>Grand Total</h4></td>
                <td><h4>{{$sale->total_price}}</h4></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center"><h4>Paid</h4></td>
                <td><h4>{{$sale->paid}}</h4></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center"><h4>Return Change</h4></td>
                <td><h4>{{$sale->r_change}}</h4></td>
            </tr>
            </tbody>
        </table>
        <div class="text-center">
            <p>Thank You</p>
            <p>Visit Again</p>
        </div>
            @if(isset($d))
                <script>
                    window.print();
                </script>
            @endif
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>

     //PageLoad
    $.get("{{ url('salesload/data') }}",
            {
            },
            function(data, status){
                // alert("Data: " + data + "\nStatus: " + status);
                var json = $.parseJSON(data);
                // alert(json);
                if(json.msg=="")
                {
                    $('#paid').val(0);
                    $('#change_amount').val("");
                    $("#sales_table").html();
                    var html = "";
                    $.each(json.sales_table,function(index,value){
                        //alert(value['code']);
                        var code = value['code'];
                        var product_id = value['product_id'];
                        var name = value['name'];
                        var quantity = value['quantity'];
                        var price = value['price'];
                        var total = value['total'];
                        html += '<tr class="'+product_id+'"><td>'+code+'</td><td>'+name+'</td><td><input type="number" autocomplete="off" size="3" name="quantity" id="qty'+product_id+'" value="'+quantity+'" style="width:50px;height:30px;text-align:center;" class="_qty" data-code="'+product_id+'"></td><td>'+price+'</td><td>'+total+'</td><td><a class="btn btn-danger _delete" id="'+product_id+'" data-rowid="'+product_id+'"><i class="fa fa-trash"></i></a></td></tr>';
                    });
                    $("#sales_table").html(html);
                    var grand_total = json.grand_total;
                    $('#grand_total').val(grand_total);
                    $('#paid').keyup(function(){
                        var paid = $('#paid').val();
                        var change_amount = paid - grand_total;
                        $('#change_amount').val(change_amount);
                    });
                }
                else
                {
                    // alert(json.msg);
                    swal.fire({
                        title: "",
                        text: json.msg,
                        customClass: {
                        popup: 'animated tada'
                        }
                    });
                }
    });
    //add to list
    $(document).keydown(function( event ) {
        if ( event.which == 32 ) {
            event.preventDefault();
            var id = $("#product_name").children(":selected").attr("value");
            $.get("{{ url('sales/data') }}",
                {
                    id: id
                },
                
                function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    var json = $.parseJSON(data);
                    // alert(json);                      
                    if(json.msg=="")
                    {
                        $('#paid').val(0);
                        $('#change_amount').val("");
                        $("#sales_table").html();
                        var html = "";
                        $.each(json.sales_table,function(index,value){
                            // alert(value['code']);
                            var product_id = value['product_id'];
                            var code = value['code'];
                            var name = value['name'];
                            var quantity = value['quantity'];
                            var price = value['price'];
                            var total = value['total'];
                            html += '<tr class="'+product_id+'"><td>'+code+'</td><td>'+name+'</td><td><input type="number" autocomplete="off" size="3" name="quantity" id="qty'+product_id+'" value="'+quantity+'" style="width:50px;height:30px;text-align: center;" class="_qty" data-code="'+name+'"></td><td>'+price+'</td><td>'+total+'</td><td><a class="btn btn-danger _delete" id="'+product_id+'" data-rowid="'+product_id+'"><i class="fa fa-trash"></i></a></td></tr>';
                        });
                        $("#sales_table").html(html);
                        var grand_total = json.grand_total;
                        $('#grand_total').val(grand_total);
                        $('#paid').keyup(function(){
                            var paid = $('#paid').val();
                            var change_amount = paid - grand_total;
                            $('#change_amount').val(change_amount);
                        });
                    }
                    else
                    {
                        // alert(json.msg);
                        swal.fire({
                            title: "",
                            text: json.msg,
                            customClass: {
                                popup: 'animated tada'
                            }
                        });
                    }
                });
        }
        
    });
    $(document).keydown(function( event ) {
        if ( event.which == 13 ) {
            event.preventDefault();
            var code = $("#productcode").val();
            $.get("{{ url('sales/data') }}",
                {
                    code: code
                },
                
                function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    var json = $.parseJSON(data);
                    // alert(json);                      
                    if(json.msg=="")
                    {
                        $('#paid').val(0);
                        $('#change_amount').val("");
                        $("#sales_table").html();
                        var html = "";
                        $.each(json.sales_table,function(index,value){
                            // alert(value['code']);
                            var product_id = value['product_id'];
                            var code = value['code'];
                            var name = value['name'];
                            var quantity = value['quantity'];
                            var price = value['price'];
                            var total = value['total'];
                            html += '<tr class="'+product_id+'"><td>'+code+'</td><td>'+name+'</td><td><input type="number" autocomplete="off" size="3" name="quantity" id="qty'+product_id+'" value="'+quantity+'" style="width:50px;height:30px;text-align: center;" class="_qty" data-code="'+name+'"></td><td>'+price+'</td><td>'+total+'</td><td><a class="btn btn-danger" id="'+product_id+'" data-rowid="'+code+'"><i class="fa fa-trash"></i></a></td></tr>';
                        });
                        $("#sales_table").html(html);
                        var grand_total = json.grand_total;
                        $('#grand_total').val(grand_total);
                        $('#paid').keyup(function(){
                            var paid = $('#paid').val();
                            var change_amount = paid - grand_total;
                            $('#change_amount').val(change_amount);
                        });
                    }
                    else
                    {
                        // alert(json.msg);
                        swal.fire({
                            title: "",
                            text: json.msg,
                            customClass: {
                                popup: 'animated tada'
                            }
                        });
                    }
                });
        }
        
    });

    (function($){
        $.fn.focusTextToEnd = function(){
            this.focus();
            var $thisVal = this.val();
            this.val('').val($thisVal);
            return this;
        }
    }(jQuery));
    //Quantity KeyUp
    $('#sales_table').on('keyup','._qty',function(){
        
            var id =$(this).attr('data-code');
            var qty =$(this).val();
            $.get("{{ url('salesqualtity/qtyadd') }}",
                {
                    id: id ,
                    qty : qty
                },
                function(data, status){

                    // alert("Data: " + data + "\nStatus: " + status);
                    var json = $.parseJSON(data);
                    //alert(json);
                    if(json.msg!="")
                    {
                        swal.fire({
                            title: "",
                            text: json.msg,
                        });
                    }
                    $('#paid').val(0);
                    $('#change_amount').val("");
                    $("#sales_table").html();
                    var html = "";
                    $.each(json.sales_table,function(index,value){
                        //alert(value['code']);
                        var code = value['code'];
                        var product_id = value['product_id'];
                        var name = value['name'];
                        var quantity = value['quantity'];
                        var price = value['price'];
                        var total = value['total'];
                        html += '<tr id="'+product_id+'"><td>'+code+'</td><td>'+name+'</td><td><input type="number" autocomplete="off" size="3" name="quantity" id="qty'+product_id+'" value="'+quantity+'" style="width:50px;height:30px;text-align: center;" class="_qty" data-code="'+product_id+'"></td><td>'+price+'</td><td>'+total+'</td><td><a class="btn btn-danger btn-xs _delete" data-rowid="'+product_id+'"><i class="fa fa-trash"></i></a></td></tr>';
                    });
                    // alert(.val());
                    $("#sales_table").html(html);
                    var grand_total = json.grand_total;
                    $('#grand_total').val(grand_total);
                    $('#paid').keyup(function(){
                        var paid = $('#paid').val();
                        var change_amount = paid - grand_total;
                        $('#change_amount').val(change_amount);
                    });
                    $('#qty'+json.id).focusTextToEnd();
                    
                });
    });
    //delete from List
    $('#sales_table').on('click','._delete',function(){
        // alert('gg');
        var id=$(this).attr('data-rowid');
        $.get("{{ url('sales/remove') }}",
            {
                id: id,
                
            },
            function(data, status){
                //alert("Data: " + data + "\nStatus: " + status);
                var json = $.parseJSON(data);
                if(json.msg=="")
                {
                    $('#paid').val(0);
                    $('#change_amount').val("");
                    $("."+json.id).html("");
                    var grand_total = json.grand_total;
                    $('#grand_total').val(grand_total);
                    $('#paid').keyup(function(){
                        var paid = $('#paid').val();
                        var change_amount = paid - grand_total;
                        $('#change_amount').val(change_amount);
                    });
                    $('#productcode').val("");
                    $('#productcode').focus();
                }
                else
                {
                    //alert(json.msg);
                    swal.fire({
                        title: "",
                        text: json.msg,
                    });
                    $('#productcode').val("");
                    $('#productcode').focus();
                }
            });
    });

    //alldelete session
    $('#allremove').on('click', function(){
        $.get("{{ url('sales/allremove') }}",
            function(data, status){
                var json = $.parseJSON(data);
                if(json.msg)
                {
                    $('#paid').val(0);
                    $('#change_amount').val("");
                    $("#sales_table").html();
                    var html = "";
                    $("#sales_table").html(html);
                    var grand_total = json.grand_total;
                    $('#grand_total').val(grand_total);
                    $('#paid').keyup(function(){
                        var paid = $('#paid').val();
                        var change_amount = paid - grand_total;
                        $('#change_amount').val(change_amount);
                    });
                    $('#productcode').val("");
                    $('#productcode').focus();

                    swal({
                        title: "",
                        text: json.msg,
                        type: "success"
                    });
                }
            });
    });
    

    
</script>
@endsection

