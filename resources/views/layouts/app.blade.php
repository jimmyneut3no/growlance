<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
	<!-- TITLE -->
    <title>Growlance Dashboard | Manage Your USDT Staking Portfolio</title>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Growlance">
	<meta name="robots" content="index, follow">
	<meta name="format-detection" content="telephone=no">

	<meta name="keywords" content="USDT staking dashboard, crypto portfolio, staking management, USDT rewards, crypto investment tracking, Growlance dashboard, digital asset management, staking analytics">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Access your Growlance dashboard to manage your USDT staking portfolio. Track your rewards, monitor performance, and optimize your staking strategy with our comprehensive dashboard tools.">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://growlance.io/dashboard">
	<meta property="og:title" content="Growlance Dashboard | USDT Staking Management">
	<meta property="og:description" content="Manage your USDT staking portfolio with Growlance's powerful dashboard. Track rewards, monitor performance, and optimize your staking strategy.">
	<meta property="og:image" content="https://growlance.io/images/dashboard-share.jpg">

	<!-- Twitter -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:url" content="https://growlance.io/dashboard">
	<meta name="twitter:title" content="Growlance Dashboard | USDT Staking Management">
	<meta name="twitter:description" content="Manage your USDT staking portfolio with Growlance's powerful dashboard. Track rewards, monitor performance, and optimize your staking strategy.">
	<meta name="twitter:image" content="https://growlance.io/images/dashboard-share.jpg">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
    <link href="{{asset('vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('vendor/chartist/css/chartist.min.css')}}">
    <link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	<link href="{{asset('vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/toastr/css/toastr.min.css')}}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
	

    @stack('styles')
    <style>
        svg{
            display: inline;
        }
        .collapse {
            visibility: inherit;
        }
    </style>
    <style>
  .theme-toggle {
    width: 60px;
    height: 30px;
    background-color: #e0e0e0;
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .theme-toggle.dark {
    background-color: #333;
  }

  .theme-toggle i {
    font-size: 18px;
    color: #000;
    transition: color 0.3s ease;
  }

  .theme-toggle.dark i {
    color: #fff;
  }
</style>

</head>
<body data-theme-version="dark">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
        <!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
<div class="nav-header">
            <a href="{{route('dashboard')}}" class="brand-logo" id="appLogo">
                    <x-application-logo  />
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
</div>
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                       
                        <!-- Page Heading -->
                        @isset($header)
                                    <div class="header-left">
                                        <div class="dashboard_bar">
                                            {{ $header }}
                                        </div>
                                    </div>
                        @endisset
                         @include('layouts.navigation')
                    </div>
                </nav>
            </div>
        </div>
         @include('layouts.sidebar')
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
                {{ $slot }}
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
                <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Growlance 2025</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
        </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
	<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
	{{-- <script src="vendor/chart.js/Chart.bundle.min.js')}}"></script> --}}
	
	<!-- Chart piety plugin files -->
    <script src="{{asset('vendor/peity/jquery.peity.min.js')}}"></script>
	
	<!-- Apex Chart -->
	{{-- <script src="{{asset('vendor/apexchart/apexchart.js')}}"></script> --}}
	<script src="{{asset('vendor/owl-carousel/owl.carousel.js')}}"></script>
	
	<!-- Dashboard 2 -->
	{{-- <script src="{{asset('js/dashboard/dashboard-4.js')}}"></script> --}}
	<script src="{{asset('js/deznav-init.js')}}"></script>
	{{-- <script src="{{asset('js/demo.js')}}"></script> --}}
    {{-- <script src="js/styleSwitcher.js"></script> --}}
        <script src="{{asset('vendor/toastr/js/toastr.min.js')}}"></script>
	<script>
    toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "5000"
};

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>

<script>
		jQuery(document).ready(function(){
    var donutChart1 = function(){
		$("span.donut1").peity("donut", {
			width: "100",
			height: "100"
		});
	}

donutChart1();
    
		});	
        

	</script>
	<script>
		// jQuery(document).ready(function(){
		// 	 setTimeout(function(){
        //         dezSettingsOptions.version = 'light';
        //         new dezSettings(dezSettingsOptions);
        //     }, 200);
            
		// });	
	</script>
<script>
  $(document).ready(function () {
    const body   = $('body');
    const toggle = $('#themeToggle');
    const icon   = $('#themeIcon');

    // 1️⃣  Get preferred theme:
    //     – first look in localStorage
    //     – otherwise fall back to OS setting
    const savedTheme   = localStorage.getItem('theme_version');
    const systemTheme  = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    const currentTheme = savedTheme || systemTheme;

    // 2️⃣  Apply that theme to the page and the switch
    body.attr('data-theme-version', currentTheme);
            if (currentTheme === 'dark') {
            $('#appLogo .fil0').css('fill', '#fff');
        } else {
            $('#appLogo .fil0').css('fill', '#000');
        }
    toggle.toggleClass('dark', currentTheme === 'dark');
    icon.toggleClass('fa-sun',  currentTheme === 'light')
        .toggleClass('fa-moon', currentTheme === 'dark');

    // 3️⃣  Toggle on click, save choice to localStorage
    toggle.on('click', function () {
      const newTheme = body.attr('data-theme-version') === 'dark' ? 'light' : 'dark';

      body.attr('data-theme-version', newTheme);
      toggle.toggleClass('dark', newTheme === 'dark');
      icon.toggleClass('fa-sun fa-moon');
      localStorage.setItem('theme_version', newTheme);
        if (newTheme === 'dark') {
            $('#appLogo .fil0').css('fill', '#fff');
        } else {
            $('#appLogo .fil0').css('fill', '#000');
        }
    });
  });
</script>

    @stack('scripts')
    </body>
</html>
