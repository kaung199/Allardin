<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>BarCode Products</title>
    <style>
        .wrap {
            width: 100%;
            margin-left: 0;
            padding-left: 0;
        }
        .wrap td {
            padding-right: 1em;
        }
        @media print {
            .no-prnt {
                display: none;
            }
            .wrap {
                width: 100%;
            }
            .pad {
                padding-left: 10px;
                padding-right: 13px;
            }
        }
        .price{
            padding-left: 6em;
        }
        .delivery_date{
            padding-left: 9.5em;
        }
        .pading-leftb {
            padding-left: 5px;
        }

    </style>
    <script src="{{asset('js/JsBarcode.ean-upc.min.js')}}"></script>
</head>
<body>
<div class="no-prnt">
    <a href="{{url('dashboard')}}" class="btn btn-primary">Back To Home</a>
    <div class="container">
        <h3 class="text-center">" <u>Barcode Generate</u> "</h3>
        <br>
        <div class="row">
            <div class="col-md-8 shadow p-3">
                <form action="{{ route('barcode') }}" method="get">
                    @csrf
                    <div class="form-group">
                        <label for="category">From Products</label>
                        <select class="form-control" name="from_product" style="width: 100%" required>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->code }} | {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">To Products</label>
                        <select class="form-control" name="to_product" style="width: 100%" required>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->code }} | {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-info">All Barcode</button>
                </form>
            </div>
        </div>
    </div>
</div>
@if(isset($pds))
    <div class="Bshow">
        <div class="wrap">
            @php
                $pdChunks = $pds->chunk(3)->toArray();
                //dd($pdChunks);
            @endphp
            @foreach($pdChunks as $pd)
                <div class="row">
                    @foreach($pd as $barcode)
                        @php
                            $barcode["code"] = preg_replace('/\s+/', '', $barcode["code"]);
                            //dd(preg_replace('/\s+/', '', $barcode["Barcode"]));
                        @endphp
                        <div class="col mb-5 mt-3 pad">
                            <span class="barcodeFont price" style="font:bold 15px monospace;">
                                {{ $barcode["price"] }} Ks
                            </span><br/>
                            <span class="text-center pl-3">
                                <b>{{ $barcode["name"] }}</b>
                            </span>
                            <br/>
                            {{--<svg id="barcode"--}}
                                 {{--jsbarcode-value="{!!  $barcode["code"] !!}">--}}
                            {{--</svg>--}}
                            <svg class="barcode d-block"
                                jsbarcode-format="CODE128"
                                jsbarcode-value="{!!  $barcode["code"] !!}"
                                jsbarcode-textmargin="0"
                                jsbarcode-fontoptions="bold"
                                jsbarcode-font ="OCRB"
                                jsbarcode-fontSize ="18">
                            </svg>

                            <br>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif
</body>
<script src="{{asset('js/JsBarcode.all.min.js')}}"></script>

<script type="text/javascript">
    JsBarcode(".barcode").init();
</script>
</html>
