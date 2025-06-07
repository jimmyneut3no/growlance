<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
	<!-- TITLE -->
    <title>Growlance - Premier USDT Staking Platform | Grow Your Crypto Assets</title>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Growlance">
	<meta name="robots" content="index, follow">
	<meta name="format-detection" content="telephone=no">

	<meta name="keywords" content="USDT staking, crypto staking, cryptocurrency, stablecoin staking, digital assets, passive income, crypto investment, Growlance, USDT rewards, crypto platform">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Growlance is a premier USDT staking platform offering secure and profitable staking opportunities. Earn passive income on your USDT holdings with our industry-leading staking rewards and robust security measures. Join thousands of satisfied users at Growlance.io">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://growlance.io/">
	<meta property="og:title" content="Growlance - Premier USDT Staking Platform">
	<meta property="og:description" content="Earn passive income through USDT staking with Growlance. Secure, reliable, and profitable staking platform for your digital assets.">
	<meta property="og:image" content="https://growlance.io/images/social-share.jpg">

	<!-- Twitter -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:url" content="https://growlance.io/">
	<meta name="twitter:title" content="Growlance - Premier USDT Staking Platform">
	<meta name="twitter:description" content="Earn passive income through USDT staking with Growlance. Secure, reliable, and profitable staking platform for your digital assets.">
	<meta name="twitter:image" content="https://growlance.io/images/social-share.jpg">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
    	<!-- Style css -->
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
	<style>
		/* Custom Styling for Stats Visual */
.stats-visual {
    max-width: 400px;
    margin: 0 auto;
}
.apy-card {
    border: 1px solid rgba(0, 0, 0, 0.05);
}
.text-gradient {
    background: linear-gradient(90deg, #26A17B, #34C759);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.trust-badges .badge {
    background: rgba(0, 0, 0, 0.03);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
}
	</style>
</head>
<body>
	<!--====== Preloader Area Start ======-->
	<div id="gameon-preloader" class="gameon-preloader">
		<!-- Preloader Animation -->
		<div class="preloader-animation">
			<!-- Spinner -->
			<div class="spinner"></div>
			<p class="fw-5 text-center text-uppercase">Loading</p>
		</div>
		<!-- Loader Animation -->
		<div class="loader-animation">
			<div class="row h-100">
				<!-- Single Loader -->
				<div class="col-3 single-loader p-0">
					<div class="loader-bg"></div>
				</div>
				<!-- Single Loader -->
				<div class="col-3 single-loader p-0">
					<div class="loader-bg"></div>
				</div>
				<!-- Single Loader -->
				<div class="col-3 single-loader p-0">
					<div class="loader-bg"></div>
				</div>
				<!-- Single Loader -->
				<div class="col-3 single-loader p-0">
					<div class="loader-bg"></div>
				</div>
			</div>
		</div>
	</div>
	<!--====== Preloader Area End ======-->

	<div class="main">
		<!-- ***** Header Start ***** -->
		<header id="header">
			<!-- Navbar -->
			<nav data-aos="zoom-out" data-aos-delay="800" class="navbar gameon-navbar navbar-expand">
				<div class="container header">

					<!-- Logo -->
					<a class="navbar-brand" href="{{route('home')}}">
						<img src="{{asset('assets/img/logo/logo.svg')}}" alt="Brand Logo" />
					</a>

					<div class="ms-auto"></div>

					<!-- Navbar Nav -->
					<ul class="navbar-nav items mx-auto">
						<li class="nav-item active">
							<a href="{{route('home')}}" class="nav-link active">Home</a>
						</li>
						<li class="nav-item">
							<a href="#how-it-works" class="nav-link">How it Works</a>
						</li>
						<li class="nav-item">
							<a href="{{route('staking-plans')}}" class="nav-link">Staking Plans</a>
						</li>
						<li class="nav-item">
							<a href="{{route('contact')}}" class="nav-link">Contact</a>
						</li>
                    @auth
                         <li class="nav-item d-block d-md-none">
							<a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
							</li>
							<li class="nav-item d-block d-md-none">
							<a href="{{ url('/logout') }}" class="nav-link">Logout</a>
							</li>
                    @else
						 <li class="nav-item d-block d-md-none">
							<a href="{{ url('/login') }}" class="nav-link">Login</a>
						</li>
                        <li class="nav-item d-block d-md-none">
							<a href="{{ url('/register') }}" class="nav-link">Register</a>
						</li>
                    @endauth
					</ul>

					<!-- Navbar Toggler -->
					<ul class="navbar-nav toggle">
						<li class="nav-item">
							<a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#menu">
								<i class="icon-menu m-0"></i>
							</a>
						</li>
					</ul>

					<!-- Navbar Action Button -->
					<ul class="navbar-nav action">
                    @auth
                    <li class="nav-item ms-2">
							<a href="{{ url('/logout') }}" class="ms-lg-auto" style=""><i class="icon-logout me-md-2"></i>Logout</a>
						</li>
                         <li class="nav-item ms-2">
							<a href="{{ url('/dashboard') }}" class="btn ms-lg-auto btn-bordered-white"><i class="icon-wallet me-md-2"></i>Dashboard</a>
						</li>
                    @else
                         <li class="nav-item ms-2">
							<a href="{{ url('/login') }}" class="btn ms-lg-auto" style="background-image:none;"><i class="icon-login me-md-2"></i>Login</a>
						</li>
						 <li class="nav-item ms-2">
							<a href="{{ url('/register') }}" class="btn ms-lg-auto btn-bordered-white"><i class="icon-arrow-right me-md-2"></i>Get Started</a>
						</li>
                    @endauth
					</ul>

				</div>
			</nav>
		</header>
		<!-- ***** Header End ***** -->

                {{ $slot }}

        		<!--====== Footer Area Start ======-->
		<footer class="footer-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-8 text-center">
						<!-- Footer Items -->
						<div class="footer-items">
							<!-- Logo -->
							<a class="navbar-brand" href="{{route('home')}}">
								<img src="{{asset('assets/img/logo/logo.svg')}}" alt="Brand Logo" width="200px" />
							</a>
							<!-- Social Icons -->
							<div class="social-icons d-flex justify-content-center my-4">
								<a class="facebook" href="https://www.facebook.com/" target="_blank">
									<i class="icon-social-facebook"></i>
									<i class="icon-social-facebook"></i>
								</a>
								<a class="twitter" href="https://twitter.com/" target="_blank">
									<i class="icon-social-twitter"></i>
									<i class="icon-social-twitter"></i>
								</a>
								<a class="linkedin" href="https://www.linkedin.com/" target="_blank">
									<i class="icon-social-linkedin"></i>
									<i class="icon-social-linkedin"></i>
								</a>
							</div>
							<ul class="list-inline">
								<li class="list-inline-item"><a href="{{route('staking-plans')}}">Staking Plans</a></li>
								<li class="list-inline-item"><a href="{{route('home')}}">How It Works</a></li>
								<li class="list-inline-item"><a href="{{route('terms-conditions')}}">Terms & Conditions</a></li>
								<li class="list-inline-item"><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
							</ul>
							<!-- Copyright Area -->
							<div class="copyright-area py-4">&copy;2024 Growlance, All Rights Reserved</div>
						</div>
						<!-- Scroll To Top -->
						<div id="scroll-to-top" class="scroll-to-top">
							<a href="#header" class="smooth-anchor">
								<i class="fa-solid fa-arrow-up"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!--====== Footer Area End ======-->

		<!--====== Modal Search Area Start ======-->
		<div id="search" class="modal fade p-0">
			<div class="modal-dialog dialog-animated">
				<div class="modal-content h-100">
					<div class="modal-header" data-bs-dismiss="modal">
						Search <i class="far fa-times-circle icon-close"></i>
					</div>
					<div class="modal-body">
						<form class="row">
							<div class="col-12 align-self-center">
								<div class="row">
									<div class="col-12 pb-3">
										<h2 class="search-title mt-0 mb-3">What are you looking for?</h2>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
									</div>
								</div>
								<div class="row">
									<div class="col-12 input-group mt-md-4">
										<input type="text" placeholder="Enter your keywords">
									</div>
								</div>
								<div class="row">
									<div class="col-12 input-group align-self-center">
										<button class="btn btn-bordered-white mt-3">Search</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--====== Modal Search Area End ======-->

		<!--====== Modal Responsive Menu Area Start ======-->
		<div id="menu" class="modal fade p-0">
			<div class="modal-dialog dialog-animated">
				<div class="modal-content h-100">
					<div class="modal-header" data-bs-dismiss="modal">
						Menu <i class="far fa-times-circle icon-close"></i>
					</div>
					<div class="menu modal-body">
						<div class="row w-100">
							<div class="items p-0 col-12 text-center"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--====== Modal Responsive Menu Area End ======-->

	</div>

	<!-- ***** All jQuery Plugins ***** -->

	<!-- jQuery(necessary for all JavaScript plugins) -->
	<script src="{{asset('assets/js/vendor/jquery.min.js')}}"></script>

	<!-- Bootstrap js -->
	<script src="{{asset('assets/js/vendor/popper.min.js')}}"></script>
	<script src="{{asset('assets/js/vendor/bootstrap.min.js')}}"></script>

	<!-- Plugins js -->
	<script src="{{asset('assets/js/vendor/all.min.js')}}"></script>
	<script src="{{asset('assets/js/vendor/gallery.min.js')}}"></script>
	<script src="{{asset('assets/js/vendor/slider.min.js')}}"></script>
	<script src="{{asset('assets/js/vendor/countdown.min.js')}}"></script>
	<script src="{{asset('assets/js/vendor/shuffle.min.js')}}"></script>

	<!-- Main js -->
	<script src="{{asset('assets/js/main.js')}}"></script>
</body>

</html>