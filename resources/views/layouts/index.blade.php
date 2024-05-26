<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AHP</title>

    <!-- Main Styles -->
    <link rel="stylesheet" href="{{ asset('assets/styles/style.min.css') }}">

    <!-- Material Design Icon -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/material-design/css/materialdesignicons.css') }}">

    <!-- mCustomScrollbar -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css') }}">

    <!-- Waves Effect -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/waves/waves.min.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/sweet-alert/sweetalert.css') }}">

    <!-- Toastr -->
	<link rel="stylesheet" href="{{ asset ('assets/plugin/toastr/toastr.css')}}">

    @yield('header')

    <!-- Color Picker -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/color-switcher/color-switcher.min.css') }}"> --}}
</head>

<body>
    <div class="main-menu">
       @include('layouts.sidebar')
    </div>
    <!-- /.main-menu -->

    <div class="fixed-navbar">
        @include('layouts.navbar')
    </div>
    <!-- /.fixed-navbar -->


    <div id="wrapper">
        <div class="main-content">

			@yield('content')

            @include('layouts.footer')
        </div>
    </div><!--/#wrapper -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  <script src="assets/script/html5shiv.min.js"></script>
  <script src="assets/script/respond.min.js"></script>
 <![endif]-->
    <!--
 ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('assets/scripts/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('assets/plugin/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/waves/waves.min.js') }}"></script>
    <!-- Full Screen Plugin -->
    <script src="{{ asset('assets/plugin/fullscreen/jquery.fullscreen-min.js') }}"></script>
    
    <!-- Toastr -->
	<script src="{{asset ('assets/plugin/toastr/toastr.min.js')}}"></script>
	<script src="{{asset ('assets/scripts/toastr.demo.min.js')}}"></script>

    @yield('js')
        
    <script src="{{ asset('assets/scripts/main.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/color-switcher/color-switcher.min.js') }}"></script> --}}
</body>

</html>
