<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="30×30" href="{{ asset('ui/images/Aladdin.png') }}">
    <link rel="shortcut icon"  sizes="30×30" href="{{ asset('ui/images/Aladdin.png') }}" type="image/png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Padauk&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <title>OrderPrepare</title>
</head>
<body>
  <div class="adminindex">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="{{ route('adminindex') }}">AladdinOnlineShop</a>
      <a href="{{ url('admincartview')}}">
        <div class="cartt">
            <?php $qtotal = 0; ?>
          @if(session('cart'))

              @foreach(session('cart') as $id => $details)				                        	
                  <?php 
                  $qtotal += $details['quantity'];
                  ?>            
              @endforeach
              <span class="badge badge-danger cartqty">{{ $qtotal }}</span>
          @endif
        <i class="fas fa-cart-arrow-down"></i>
        </div>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('dashboard') }}">Dashboard<span class="sr-only">(current)</span></a>
            </li>
            @endif
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('adminindex') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('order_cart') }}">Order_Cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('adminorders') }}">Orders</a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </li>     
          
        </ul>
        <form class="form-inline my-2 my-lg-0" action="{{ route('searchproducts') }}" method="POST">
        @csrf
          <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
        <div class="container pt-3 pb-3">
            @yield('contents')
        </div>
      
      
    <div class="bg-dark footerhide">
        <p class="text-center pt-3 pb-3 text-muted">Copyright © Medifuture co.,ltd 2020</p>
    </div>
  </div>
</body>
</html>