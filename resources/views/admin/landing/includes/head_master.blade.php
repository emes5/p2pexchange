<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{allsetting('app_title')}}"/>
    <meta property="og:image" content="{{show_image(1,'logo')}}">
    <meta property="og:site_name" content="{{allsetting('app_title')}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta itemprop="image" content="{{show_image(1,'logo')}}"/>
    @php
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https' : 'http';
    @endphp
    @if($protocol=='https')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/common/css/bootstrap.min.css')}}">
    <!-- metismenu CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/metisMenu.min.css')}}">
    <!-- fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/icofont.min.css')}}">
    {{-- owl carousel --}}
    <link rel="stylesheet" href="{{asset('assets/common/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/owl.theme.default.min.css')}}">
    {{--for toast message--}}
    <link href="{{asset('assets/common/toast/vanillatoasts.css')}}" rel="stylesheet">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/landing/master/style.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('assets/landing/master/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/plugins.css')}}" />
    <title>@yield('title') </title>
    <!-- Favicon and Touch Icons -->
    <link rel="shortcut icon" href="{{landingPageImage('favicon','images/Pexeer.svg')}}">
    <script src="{{asset('assets/landing/custom/assets/js/jquery-3.6.0.min.js')}}"></script>
    <link href="{{asset('assets/landing/custom/assets/js/ladda/ladda-themeless.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/landing/custom/assets/js/sweetalert/sweetalert2.all.min.js')}}"></script>
    <link href="{{asset('assets/landing/custom/assets/js/sweetalert/sweetalert.css')}}" rel="stylesheet">
    @yield('style')
</head>
