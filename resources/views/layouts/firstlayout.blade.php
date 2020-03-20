
<!DOCTYPE html>
<html lang="en">
<head>
<title>
	Aladdin -
    @yield('title')
</title>
<meta charset="utf-8">
<link rel="apple-touch-icon" sizes="30×30" href="{{ asset('ui/images/Aladdin.png') }}">
<link rel="shortcut icon" sizes="30×30" href="{{ asset('ui/images/Aladdin.png') }}" type="image/png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{{ asset('ui/css/bootstrap.css') }}" rel='stylesheet' type='text/css' />
<link href="{{ asset('ui/css/style.css') }}" rel='stylesheet' type='text/css' />
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('ui/css/etalage.css') }}">
<link href="{{ asset('ui/css/magnific-popup.css') }}" rel="stylesheet" type="text/css">
<script src="{{  asset('ui/js/jquery.min.js') }}"></script>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="{{ asset('ui/js/jquery.easydropdown.js') }}"></script>
<script src="{{ asset('ui/js/jquery.magnific-popup.js') }}" type="text/javascript"></script>
<script src="{{ asset('ui/js/jquery.etalage.min.js') }}"></script>
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
					<a href="{{ url('/') }}">
						<div class="col-md-2 col-sm-12">
							<div class="logoaladdin">
								<img src="/ui/images/Aladdin.png" alt="">
							</div>
						</div>
					</a>
					<div class="col-md-6 col-sm-12">
						<div class="searchbar">
							<div class="header-search clearfix">
								<div class="header-search-form">
									<form action="{{ route('productssearch') }}" method="get">
										@csrf
										<input type="text" name="search" placeholder="Search product...">
										<input type="submit">
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
		<div class="youtubelayout">
			@yield('youtube')
		</div>
		<div class="messenger">
			<a href="https://www.messenger.com/t/108801377417228">
			{{-- <a href="https://l.messenger.com/l.php?u=https%3A%2F%2Fm.me%2F107507034215941&h=AT1daWAu42wwW1x09yX7wHxkPK8sxJf9keHfX4e5iSBDo-AIDoi92RXQvj_xla1s71opiiXFOpPfyGcdDYMz9RvPToEf5fv8vGIHbF6gaIV4_K3mBTglx2bJ56Vifg"> --}}
				<img src="{{ asset('ui/images/messenger.png') }}" class="img-responsive" style="width:50px height:50px" alt="">
			</a>
		</div>
		<div class="messageerbg">
			<div class="container paddingtb">
				<div class="borderpd">
					<div class="textpadding">
						<h3>How To Buy!</h3>
						<p>မိမိဝယ္ယူလိုေသာ ပစၥည္းအား Screen Shot ရုိက္ျပီး <img src="{{ asset('ui/images/messenger.png') }}" alt="" style="width:30px; height:30px;"> Messenger Button Icon ေလးကို ႏွိပ္ျပီး ေရွ႕ဆက္သြားမည္ ႏွိပ္ကာ Aladdin Online Messenger ထဲ ေရာက္သြားေသာအခါတြင္ Screen Shots ရုိက္ထားေသာ ယူမည့္ပစၥည္းမ်ားအား ပို႔ေပးျပီး မွာယူအားေပးႏုိင္ပါျပီ။ အားေပးမႈ အတြက္ အထူးပင္ ေက်းဇူးတင္ရွိပါတယ္။</p>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="container">
				<h3>About Us</h3>
				<p>Aladdin Onlineshopping သည္ လူသံုးကုန္ပစၥည္းမ်ားအား အတစ္ေနရာတည္းတြင္ ေစ်းႏႈန္းသက္သာစြာျဖင့္ ဝယ္ယူႏုိင္ျပီး ယံုၾကည္စိတ္ခ်ရေသာ Online Shopping ျဖစ္ပါတယ္။ ရန္ကုန္ျမိဳ႕ႏွင့္ ျမိဳ႕နယ္ေပါင္း ၁၀၀ ေက်ာ္ကို ပစၥည္းေရာက္ေငြေခ် စနစ္ျဖင့္ ပို႔ေဆာင္ေပးေနျပီျဖစ္ပါတယ္။ </p>	
				<div class="row">
					<div class="col-md-3">
						<h4>Phone:</h4>
						<p>09-686781222</p>
					</div>
					<div class="col-md-3">
						<h4>Facebook:</h4>
						<p>
							<a href="https://www.facebook.com/Aladdin-Myanmar-online-shopping-108801377417228/">www.facebook.com/Aladdin-Online-Shopping</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="footer_bottom">
			<div class="container">
				<div class="copy">
					<p> Copyright &copy;2020 Medifuture co.,ltd</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>		