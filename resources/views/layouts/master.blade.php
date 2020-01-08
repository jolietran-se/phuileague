<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PhuiLeague-Hệ thống quản lý giải đấu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/phuileague.png') }}">    
    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- font-awesome css -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('bower_components/animate.css/animate.css') }}">
    <!-- Main Menu css -->
    <link rel="stylesheet" href="{{ asset('css/rsmenu-main.css') }}">
    <!-- rsmenu transitions css -->
    <link rel="stylesheet" href="{{ asset('css/rsmenu-transitions.css') }}">
    <!-- hover-min css -->
    <link rel="stylesheet" href="{{ asset('bower_components/hover/css/hover-min.css') }}">
        <!-- magnific-popup css -->
    <link rel="stylesheet" href="{{ asset('bower_components/magnific-popup/dist/magnific-popup.css') }}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/time-circles.css') }}">
    <!-- Slick css -->
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- responsive css -->
    
    {{-- <link rel="shortcut icon" type="image/x-icon" href="'images/fav.png') }}">     --}}
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- Jquery js -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Menu js -->
    <script src="{{ asset('js/rsmenu-main.js') }}"></script> 
    <!-- jquery-ui js -->
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- meanmenu js -->
    <script src="{{ asset('js/jquery.meanmenu.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('bower_components/wow/dist/wow.min.js') }}"></script>
    <!-- Slick js ******************* -->
    <script src="{{ asset('bower_components/slick/dist/slick.min.js') }}"></script> 
    <!-- masonry js -->
    {{-- <script src="{{ asset('bower_components/masonry-layout/masonry.js') }}"></script> --}}
    <!-- magnific-popup js -->
    <!-- owl.carousel js -->
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/time-circle.js') }}"></script>
    <!-- magnific-popup js -->
    <script src="{{ asset('bower_components/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('js/main.js') }}"></script>
    
    {{-- Scripts, Fonts, Styles Header in View --}}
    @yield('head')
</head>
<body>
    @include('layouts.header') <!-- Header Menu -->
    <div class="main">
        @yield('content')
    </div>
    @include('layouts.footer')
    @yield('foot')
</body>
</html>