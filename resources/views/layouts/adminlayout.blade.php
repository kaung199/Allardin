<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="apple-touch-icon" sizes="80×100" href="{{ asset('ui/images/Aladdin.png') }}">
    <link rel="shortcut icon" href="{{ asset('ui/images/Aladdin.png') }}" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Custom fonts for this template-->
  <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

  <!-- Page level plugin CSS-->
  <link href="/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top"> 
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    @if(Auth::user()->role_id == 1)
    <a class="navbar-brand mr-1" href="{{ route('dashboard') }}">Aladdin Dashboard</a>
    @endif
    @if(Auth::user()->role_id == 2)
    <a class="navbar-brand mr-1" href="#">Aladdin Dashboard</a>
    @endif
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ route('search') }}" method="GET">
      @csrf
      <div class="input-group">
        <input type="text" name="query" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit" value="Search">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <?php 
      $qtotal = 0;
      $gtotal = 0;
    ?>
    <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if(session('cart'))
          @foreach(session('cart') as $id => $details)				                        	
              <?php 
                $qtotal += $details['quantity'];
                $total = $details['quantity'] * $details['price'];
                $gtotal += $details['quantity'] * $details['price'];
              ?>            
          @endforeach
          <span class="badge badge-danger">{{ $qtotal }}</span>
        @endif
         
        <i class="fas fa-shopping-cart"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Totalqty&nbsp;=&nbsp;<span class="badge badge-danger">{{ $qtotal }}</span></a>
          <a class="dropdown-item" href="#">Totalprice&nbsp;=&nbsp;<span class="badge badge-danger">{{ $gtotal }}</span></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ url('cartview') }}">View Cart</a>
          
        </div>
      </li>
      
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="badge badge-danger">0+</span>
          <i class="fas fa-bell fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="badge badge-danger">0+</span>          
        <i class="fas fa-envelope fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item">{{ Auth::user()->name }}</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
    @if(Auth::user()->role_id == 1)
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
    @endif
      <li class="nav-item">
        <a class="nav-link" href="{{ url('products') }}">
        <i class="fas fa-umbrella text-primary"></i>
          <span>Products</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('townships') }}">
        <i class="fas fa-city text-warning"></i>
          <span>Townships</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('order_cart') }}">
        <i class="fas fa-shopping-cart text-danger"></i>
          <span>Order_Cart</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('order') }}">
        <i class="fab fa-accessible-icon text-success"></i>
          <span>Orders</span></a>
      </li>
      @if(Auth::user()->role_id == 1)
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-file-pdf text-info"></i>
          <span>Reports</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ route('daily') }}">Today Orders</a>
          <a class="dropdown-item" href="{{ route('monthly') }}">Monthly Order</a>
          <a class="dropdown-item" href="{{ route('yearly') }}">Yearly Order</a>
        </div>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" href="{{ route('customers') }}">
        <i class="fas fa-users text-warning"></i>
          <span>Customers</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('deliveries') }}">
        <i class="fas fa-car text-danger"></i>
          <span>Delivery</span></a>
      </li>
      @if(Auth::user()->role_id == 1)
      <li class="nav-item">
        <a class="nav-link" href="{{ route('deliveries.create') }}">
        <i class="fas fa-user-plus text-info"></i>
          <span>Accounts Create</span></a>
      </li>
      @endif
      @if(Auth::user()->role_id == 1)
      <li class="nav-item">
        <a class="nav-link" href="{{ route('totalsale') }}">
        <i class="fas fa-search-dollar text-success"></i>
          <span>Daily Total Sale</span></a>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" href="#">
        <i class="fas fa-id-card text-primary"></i>
          <span>Profile</span></a>
      </li>
      @if(Auth::user()->role_id == 1)
      <li class="nav-item">
        <a class="nav-link" href="{{ route('adminindex') }}">
        <i class="fas fa-mobile-alt text-success"></i>
          <span>Add Orders</span></a>
      </li>
      @endif
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
            
          </li>
          @yield('breadcrumbs')
        </ol>

        <div class="shadow pt-3 pl-3 pb-5 pr-3">
          <div class="table-responsive-sm">
            @yield('contents')
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Medifuture co.,ltd 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>


  <!-- Custom scripts for all pages-->
  <script src="{{ asset('/tjs/sb-admin.min.js') }}"></script>

</body>

</html>
