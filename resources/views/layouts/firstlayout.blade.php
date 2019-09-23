
<!DOCTYPE html>
<html lang="en">
<head>
<title>
    @yield('title')
</title>
<link href="{{ asset('ui/css/bootstrap.css') }}" rel='stylesheet' type='text/css' />
<script src="/ui/js/jquery.min.js"></script>
<link href="/ui/css/style.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href='http://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
<script src="/ui/js/jquery.easydropdown.js"></script>
<link href="https://fonts.googleapis.com/css?family=Padauk&display=swap" rel="stylesheet">
<link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<script src="/ui/js/jquery.magnific-popup.js" type="text/javascript"></script>
<link href="/ui/css/magnific-popup.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/ui/css/etalage.css">
<script src="/ui/js/jquery.etalage.min.js"></script>
<script src="{{ asset('js/easyResponsiveTabs.js')}}" type="text/javascript"></script>
		<script>
			$(document).ready(function() {
				$('.popup-with-zoom-anim').magnificPopup({
					type: 'inline',
					fixedContentPos: false,
					fixedBgPos: true,
					overflowY: 'auto',
					closeBtnInside: true,
					preloader: false,
					midClick: true,
					removalDelay: 300,
					mainClass: 'my-mfp-zoom-in'
				});
			});
		
			jQuery(document).ready(function($){
				
				$('#etalage').etalage({
					thumb_image_width: 350,
					thumb_image_height: 370,
					smallthumb_select_on_hover: false, 					
					show_hint: true,
					
				});
				// This is for the dropdown list example:
				$('.dropdownlist').change(function(){
					etalage_show( $(this).find('option:selected').attr('class') );
				});

			});
		</script>
</head>

<body>
	<div class="userindex">
		<div class="menubar">
			<div class="container">
				<div class="row">
					<div class="col-md-2 col-sm-12">
						<div class="logoaladdin">
							<img src="/ui/images/logo.png" alt="">
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="searchbar">
							<div class="header-search clearfix">
								<div class="header-search-form">
									<form action="#" method="get">
										@csrf
										<input type="text" name="query" placeholder="Search product...">
										<input type="submit" name="submit" value="Search">
									</form>                                    
								</div>
							</div>
						</div>
						
					</div>
					<div class="col-md-4 col-sm-12">
						<div class="cart">
							<i class="fas fa-cart-arrow-down"></i>
						</div>
					</div>
				</div>
			</div>		
		</div>
		<div class="main">
		<div class="content_box">
			<div class="container">
					<div class="content_grid">
						<!-- content start -->
						@yield('contents')
						<!-- content end -->
				</div>
			</div>
			</div>
		</div>
		<div class="footer">
			<div class="container">
				<h3>About Us</h3>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur ut veniam dicta. Doloribus, cum repellat, aliquid unde illo eius illum debitis recusandae cumque deleniti itaque. Delectus asperiores in commodi. Nihil.</p>	
				<div class="row"> 			
					<div class="col-md-3">
						<h4>Contact:</h4>
						<p>No.123, Yangon, Familydoctor</p>
					</div>
					<div class="col-md-3">
						<h4>Phone:</h4>
						<p>098734783478, 093748346836</p>
					</div>
					<div class="col-md-3">
						<h4>Email:</h4>
						<p>example@gmail.com</p>
					</div>
					<div class="col-md-3">
						<h4>Facebook:</h4>
						<p>www.facebook.com</p>
					</div>
				</div>
			</div>
		</div>
		<div class="footer_bottom">
			<div class="container">
				<div class="copy">
					<p> Copyright &copy;2019 Medifuture co.,ltd</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>		