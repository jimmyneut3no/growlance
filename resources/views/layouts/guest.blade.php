<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Welcome to Growlance | Start Your USDT Staking Journey</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Growlance">
        <meta name="robots" content="index, follow">
        <meta name="format-detection" content="telephone=no">

        <meta name="keywords" content="USDT staking signup, crypto registration, staking platform, USDT investment, crypto welcome, Growlance registration, digital asset platform, staking signup">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Welcome to Growlance - Your gateway to USDT staking. Create an account to start earning passive income through our secure and profitable staking platform. Join our community of successful crypto investors today.">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://growlance.io/register">
        <meta property="og:title" content="Welcome to Growlance | USDT Staking Platform">
        <meta property="og:description" content="Start your USDT staking journey with Growlance. Create an account to access our secure and profitable staking platform.">
        <meta property="og:image" content="https://growlance.io/images/welcome-share.jpg">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="https://growlance.io/register">
        <meta name="twitter:title" content="Welcome to Growlance | USDT Staking Platform">
        <meta name="twitter:description" content="Start your USDT staking journey with Growlance. Create an account to access our secure and profitable staking platform.">
        <meta name="twitter:image" content="https://growlance.io/images/welcome-share.jpg">

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        
    </head>
    <body class="vh-100" data-theme-version="dark">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="{{route('home')}}" class="d-flex justify-content-center">
                                            <img src="images/logo/logo-icon.svg" alt="">
                                        </a>
									</div>
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
	<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
	<script src="{{asset('js/deznav-init.js')}}"></script>
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
    });
  });
</script>
</body>
</html>
