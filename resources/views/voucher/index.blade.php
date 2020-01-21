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
        @if(session('exist'))
            <div class="alert alert-danger">{{ session('exist') }}</div>
        @endif
        @if(session('notDelivery'))
            <div class="alert alert-danger">{{ session('notDelivery') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        @if(session('notFound'))
            <div class="alert alert-danger">{{ session('notFound') }}</div>
        @endif
        <form action="{{ route('voucher_search') }}" method="get">
        @csrf
            <div class="text-center">
                <input type="text" class="form-control @if(session('notFound') ||  session('exist') ||  session('notDelivery')) is-invalid @endif" style="width: 100%" name="order_id" placeholder="Enteer Voucher No." onblur="this.focus()" autofocus />
            </div>
        </form>
        <br><br>
        @if(session('voucher_data'))
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
            <tbody>
                @php
                    $i = 0;
                    $total = 0;
                @endphp
              <tr>
                    @foreach(session('voucher_data') as $vd)
                        <tr>
                            @php
                                $i++;
                                $total += $vd['grand_total'];
                            @endphp
                            <td>{{ $i }}</td>
                            <td>{{ $vd['order_id'] }}</td>
                            <td>{{ $vd['cus_name'] }}</td>
                            <td>{{ $vd['d_name'] }}</td>
                            <td>{{ $vd['d_date'] }}</td>
                            <td class="text-left">{{ $vd['total_qty'] }}</td>
                            <td class="text-left">{{ $vd['grand_total'] }}</td>
                        </tr>
                    @endforeach
                    <thead class="thead-light">
                        <tr>
                          <th scope="col" colspan="6" class="text-center pt-3"><h5>Grand Total</h5></th>
                        <th scope="col" class="pt-3 text-left"><h5>{{ $total }}</h5></th>
                        </tr>
                      </thead>
              </tr>
            </tbody>
          </table>
          <br>
          <div class="float-right">
            <a href="{{ route('voucher_cancel') }}" class="btn btn-danger" onclick="return confirm('Are you sure to cancel?')">Cancel</a>
            &nbsp;
            <a href="{{ route('voucher_confirm') }}" class="btn btn-success" onclick="return confirm('Are you sure to submit?')">Confirm</a>
            @endif
          </div>
        
        
    </div>
</body>
</html>