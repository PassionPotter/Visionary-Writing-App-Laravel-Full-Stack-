<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Visionary Writings') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <!-- Toastr css -->
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

    <!-- Bootstrap Core CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">

    <!-- Graph CSS -->
    <link href="{{asset('admin/css/lines.css')}}" rel='stylesheet' type='text/css' />

    <!-- FA CSS -->
    <link href="{{asset('admin/css/font-awesome.css')}}" rel="stylesheet"> 

    <!-- jQuery -->
    <script src="{{asset('admin/js/jquery.min.js')}}"></script> 

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>

    <!-- Toastr js -->
    <script type="text/javascript" src="{{asset('js/toastr.js')}}"></script>

    <!-- Nav CSS -->
    <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet">

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('admin/js/metisMenu.min.js')}}"></script>

    <!-- custom js -->
    <script src="{{asset('admin/js/custom.js')}}"></script>

    <!-- Graph JavaScript -->
    {{-- <script src="{{asset('admin/js/d3.v3.js')}}"></script>
    <script src="{{asset('admin/js/rickshaw.js')}}"></script> --}}

    <!-- Custom CSS -->
    <link href="{{asset('admin/css/style.css')}}?t=<?PHP echo time(); ?>" rel='stylesheet' type='text/css' />
</head>
    <body>
        @include('admin.layouts.partials.header')
        @include('admin.layouts.partials.sidebar-nav')
        @yield('content')
        
            <script>
            @if(Session::has('success'))
                toastr.success("{{Session::get('success')}}");
            @endif

        @if(Session::has('info'))
                toastr.info("{{Session ::get('info')}}");
            @endif

        @if(Session::has('failure'))
            toastr.error("{{Session::get('failure')}}");
        @endif
        </script>
        @yield('scripts')
        @include('admin.layouts.partials.footer')
