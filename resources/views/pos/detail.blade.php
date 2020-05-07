@extends('layouts.pos')

@section('contents')
    <div class="shadow">
        <div class="row p-2">
            <div class="col-md-6">
                <h2 class="text-danger">Sale Detail</h2>
            </div>
            <div class="col-md-6">
                <div class="folat-right" style="float: right;">
                    {{-- <h6 class="text-primary">Back</h6> --}}
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="shadow p-1">
        <table class="table-border">
            <tbody>
              <tr>
                <th colspan="2">Bill No::</th>
                <td class="text-right">{{ $sale->invoice_no }}</td>
              </tr>
              <tr>
                <th colspan="2">Date::</th>
                <td class="text-right">{{ $sale->created_at }}</td>
              </tr>
              <tr>
                <th colspan="2">Sale by::</th>
                <td class="text-right">{{ $sale->user->name }}</td>
              </tr>
            </tbody>
        </table>
    </div>
    <br>
    <div class="shadow">
       
        <div class="table-responsive-sm">
            <table class="table table-border">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Qty</th>
                    <th scope="col" class="text-right">Price</th>
                    <th scope="col" class="text-right">Total Price</th>
                    </tr>
                </thead>
                @php
                    $i;
                @endphp
                <tbody>
                    @foreach($sale->saleDetail as $s)
                    @php
                        $i++;
                    @endphp
                        <tr>
                        <th scope="row">{{ $i }}</th>
                        <th scope="row">{{ $s->product->name }}</th>
                        <th scope="row">{{ $s->product->code }}</th>
                        <td>{{ $s->qty }}</td>
                        <td class="text-right">{{ $s->product->price }}</td>
                        <td class="text-right">{{ $s->total_price }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="5" class="text-center">Grand Total</th>
                    <th class="text-right">{{ $s->sale->total_price }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <button onclick="goBack()" class="btn btn-primary">Go Back</button>
    <button onclick="window.print();" class="btn btn-success">Print</button>
    <div class="printarea">
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
        @foreach($sale->saleDetail as $d)
        
        <tr>
            <td>{{  $d->product->name }}</td>
            <td>{{  $d->qty }}</td>
            <td>{{  $d->total_price }}</td>
            <td>{{  $d->qty * $d->product->price }}.00</td>
        </tr>
        @endforeach
            <tr>
                <th colspan="3" class="text-center"><h5>Grand Total</h5></th>
                <th><h5>{{$sale->total_price}}</h5></th>
            </tr>
            <tr>
                <th colspan="3" class="text-center"><h5>Paid</h5></th>
                <th><h5>{{$sale->paid}}</h5></th>
            </tr>
            <tr>
                <th colspan="3" class="text-center"><h5>Return Change</h5></th>
                <th><h5>{{$sale->r_change}}</h5></th>
            </tr>
            </tbody>
        </table>
        <div class="text-center">
            <p>Thank You</p>
            <p>Visit Again</p>
        </div>
    </div>

<script>
    function goBack() {
        window.history.back();
        }
</script>
@endsection

