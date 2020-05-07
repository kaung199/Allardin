
@extends('layouts.pos')


@section('contents')
    <div class="shadow">
        <div class="row p-2">
            <div class="col-md-6">
                <h2 class="text-danger">Sale Report</h2>
            </div>
            <div class="col-md-6">
                <div class="folat-right" style="float: right;">
                    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('sale-search') }}" method="GET">
                        @csrf
                        <div class="input-group">
                            <label for="from">From</label>
                            <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="from" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                            <label for="to">To</label>
                            <input type="date" data-date-inline-picker="true" style="box-shadow: none;" name="to" class="form-control" aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" value="search">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="shadow">
       
        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Invoice</th>
                    <th scope="col">Total Qty</th>
                    <th scope="col" class="text-right">Total Price</th>
                    <th scope="col">Date</th>
                    <th scope="col">Sale by</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        <tr>
                        <th scope="row">{{ $sale->invoice_no }}</th>
                        <td>{{ $sale->qty }}</td>
                        <td class="text-right">{{ $sale->total_price }}</td>
                        <td>{{ $sale->created_at }}</td>
                        <td>{{ $sale->user->name }}</td>
                        <td>
                        <a class="btn btn-primary" href="{{ route('sale-detail', $sale->id) }}">Detail</a>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

