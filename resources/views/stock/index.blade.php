@extends('layouts.adminlayout')

@section('title')
    Stock-Check 
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Stock-Check</li>
@endsection
@section('contents') 
    <div class="row">
        <div class="col-md-3 text-left">
            <h4 class="" data-toggle="modal" data-target="#Completed" style="cursor:pointer;">Completed <span class="text-success">( {{ $count_c }} )</span></h3>
        </div>
        <div class="col-md-3 text-left">
            <h4 class="" data-toggle="modal" data-target="#InComplete" style="cursor:pointer;">InComplete <span class="text-danger">( {{ $count_inC }} )</span></h3>

        </div>
        <div class="col-md-6 text-right">
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('search-stock-check') }}" method="GET">
                @csrf
                <div class="input-group">
                    <label for="from">From</label>
                    <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="start_date" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                    <label for="to">To</label>
                    <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="end_date" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" value="search">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="shadow">
        <div class="pt-2 pb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalExample">
                <i class="fa fa-save fa-fw"></i> New Check
            </button>
            <div class="float-right pr-3">
                <div class="input-group">
                    <input type="text" style="box-shadow: none;" class="form-control" placeholder="Search by Name" id="myInput" onkeyup="myFunction()">
                </div>
            </div>
        </div>
        
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    <th>Name</th>

                    @if(Auth::user()->id == 1)
                        <th>InStock</th>
                    @endif

                    <th>Checked Stock</th>

                    @if(Auth::user()->id == 1)
                        <th>Real-Time-Stock</th>
                        <th>Balance</th>
                    @endif

                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product) 
                    <tr>
                        <td>{{ $product->product->name }}</td>

                        @if(Auth::user()->id == 1)
                            <td>{{ $product->product->quantity }}</td>
                        @endif

                        <td>{{ $product->qty }}</td>

                        @if(Auth::user()->id == 1)
                            <td>{{ $product->r_qty }}</td>
                            <td>{{ $product->product->quantity - $product->r_qty }}</td>
                        @endif
                        <td>{{ $product->date }}</td>
                        <td>
                            <div class="col-md-2">
                                <a href="#" class="btn btn-primary  btn-circle"
                                data-toggle="modal" data-target="#modal-edit{{ $product->id }}" id="modal-edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>                            
                        </td>

                        <!-- edit users -->
                        <div id="modal-edit{{ $product->id }}" class="modal fade edit">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-xs-center">Edit Stock Check</h4>
                                    </div>
                                    <div class="modal-body">
                                    <form role="form" method="post" action="{{ route('stock-check-update', $product->id)}}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label for="inputName">Name</label>
                                                <select class="form-control js-example-basic-single" data-live-search="true" name="product_id" style="width: 100%" required>
                                                        <option value="{{$product->product->id}}" class="zawgyi-one">{{$product->product->name}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="sale_price">Check Qty</label>
                                                <input type="decimal" class="form-control" id="sale_price" placeholder="Enter Qty" name="qty" value="{{ $product->qty }}" required/>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6 btm-pad">
                                                        <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Close</button>
                                                    </div>
                                                    <div class="col-md-6 btm-pad">
                                                        <button type="submit" class="btn btn-info btn-block">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

    <!-- create stock-check -->
    <div id="ModalExample" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-xs-center">Create Check Stock</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="{{ route('stock-check-create') }}" method="POST">
                        @csrf 

                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <select class="form-control js-example-basic-single" data-live-search="true" name="product_id" style="width: 100%" required>
                                    @foreach($inStocks as $item)
                                        <option value="{{$item->id}}" class="zawgyi-one">{{$item->name}}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="qty">Check Qty</label>
                            <input type="number" class="form-control" id="qty" placeholder="Enter your check Stock Qty" name="qty" required/>
                        </div>
                        
                        <div class="form-group">
                            {{-- <label for="date">Date</label> --}}
                            <input type="hidden" id="date" name="date" value="{{ date('Y-m-d') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 btm-pad">
                                    <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Close</button>
                                </div>
                                <div class="col-md-6 btm-pad">
                                    <button type="submit" class="btn btn-info btn-block">SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- InComplete Check -->
    <div id="InComplete" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">InComplete Check Producs</h3>
                </div>
                <div class="modal-body">
                    @foreach ($inComplete as $Inc)
                <h5 class="text-center p-name-pad zawgyi-one">{{ $Inc->name }}</h5>
                <hr>
                    @endforeach
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Complete Check -->
    <div id="Completed" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">Complete Check Producs</h3>
                </div>
                <div class="modal-body">
                    @foreach ($completed as $c)
                        <h5 class="text-center p-name-pad zawgyi-one">{{ $c->name }}</h5>
                        <hr>
                    @endforeach
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
        @if(session('success'))        
                Swal.fire({
                    title: 'Success!',
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                })      
        @endif
    
    </script>

@endsection
