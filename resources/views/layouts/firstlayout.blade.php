
<!DOCTYPE HTML>
<html>
<head>
<title>
    @yield('title')
</title>
<link href="/ui/css/bootstrap.css" rel='stylesheet' type='text/css' />
<script src="/ui/js/jquery.min.js"></script>
<link href="/ui/css/style.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href='http://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
<script src="/ui/js/jquery.easydropdown.js"></script>
<link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<script src="/ui/js/jquery.magnific-popup.js" type="text/javascript"></script>
<link href="/ui/css/magnific-popup.css" rel="stylesheet" type="text/css">

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
		</script>
</head>
<style>
	.menubar {
		width: 100%;
		padding: 15px 0 15px 0;
		background: #ffffff;
		-webkit-box-shadow: 0px 3px 10px -2px rgba(128,123,128,1);
		-moz-box-shadow: 0px 3px 10px -2px rgba(128,123,128,1);
		box-shadow: 0px 3px 10px -2px rgba(128,123,128,1);
	}
	.pdl {
		padding-left: 30px;
	}
	.menubar h1 {
		float:left;
	}
	.menubar h2 {
		text-align:center;
	}
	.menubar .cart {
		float:right;
		padding-top: 26px;
		font-size: 40px;
	}
	.logoaladdin img{
		width: 120px;
    	height: 105px;
	}
	.searchbar {
		padding-top: 26px;
	}
	.footer {
		color: #ffffff;
	}
	.footer h4 {
		margin-bottom: 3px !important;
		margin-top: 10px !important;
	}
	.header-search {
		background-color: transparent;
    	border: 1px solid #ededed;
		border-radius: 5px;
		max-width: 100%;
		padding-left: 0px;
		padding-right: 130px;
		position: relative;
	}
	.header-search-form {
		overflow: hidden;
	}
	.header-search-form form input[type="text"] {
		height: 52px;
		background: rgb(255, 255, 255);
		padding: 0px 15px;
	}
	.header-search-form input {
		margin-bottom: 0px;
		border-width: 0px;
		border-style: initial;
		border-color: initial;
		border-image: initial;
		box-shadow: none;
		font-size: 14px;
		color: rgb(98, 98, 98);
		width: 100%;
	}
	.header-search-form form input[type="submit"] {
		height: 52px;
		padding: 0px 42px;
		position: absolute;
		right: 0px;
		top: 0px;
		font-size: 14px;
		font-weight: 400;
		border-radius: 0px 5px 5px 0px;
		width: auto;
		background-color: rgb(51, 51, 51);
		color: rgb(255, 255, 255);
		cursor: pointer;
		transition: all 0.3s ease 0s;
		box-shadow: none;
		line-height: 1;
	}
</style>
<body>
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
</body>
</html>		