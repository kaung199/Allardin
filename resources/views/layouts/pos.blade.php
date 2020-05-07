<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="apple-touch-icon" sizes="30×30" href="{{ asset('ui/images/Aladdin.png') }}">
        <link rel="shortcut icon"  sizes="30×30" href="{{ asset('ui/images/Aladdin.png') }}" type="image/png">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" rel="stylesheet">
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
        <title>POS</title>
    </head>
<body>
  <div class="adminindex">
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <a class="navbar-brand" href="{{ route('pos') }}">Kitchen Venus</a>
  
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            @if(Auth::user()->role_id == 1)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard') }}">
                  <i class="fas fa-home fa-fw"></i>Home <span class="sr-only">(current)</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="{{ route('report') }}">
                <i class="fas fa-search-dollar"></i>SaleReport <span class="sr-only">(current)</span>
              </a>
            </li>
            @if(Auth::user()->role_id == 1)
            <li class="nav-item">
            <a class="nav-link" href="{{ route('total-sale') }}">
              <i class="fas fa-file-pdf"></i> DailyTotalSale <span class="sr-only">(current)</span>
            </a>
            @endif
            </li>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user-circle fa-fw"></i>{{ Auth::user()->name }}
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
        </div>
      </nav>

        <div class="container pt-5 pb-5" style="min-height:900px">
            @yield('contents')
        </div>
      
      
    <div class="bg-danger text-white" >
        <p class="text-center pt-3 pb-3 text-muted">Copyright © Medifuture co.,ltd 2020</p>
    </div>
  </div>
</body>
</html>