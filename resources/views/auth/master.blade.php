<!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="article" />
        <meta property="og:title" content="{{allsetting('app_title')}}"/>
    <meta property="og:image" content="{{show_image(1,'logo')}}">
    <meta property="og:site_name" content="{{allsetting('app_title')}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta itemprop="image" content="{{show_image(1,'logo')}}" />
    <link rel="shortcut icon" href="{{landingPageImage('favicon','images/Pexeer.svg')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/bootstrap.min.css')}}">
    <!-- metismenu CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/metisMenu.min.css')}}">
    <!-- fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/font-awesome.min.css')}}">
    {{--for toast message--}}
    <link href="{{asset('assets/common/toast/vanillatoasts.css')}}" rel="stylesheet" >
    @if(isset(allsetting()['google_recapcha']) && allsetting()['google_recapcha'])
    {!! NoCaptcha::renderJs() !!}
    @endif
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/admin/style.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/responsive.css')}}">
    @yield('style')
    <title>@yield('title') </title>
    <!-- Favicon and Touch Icons -->
    <link rel="shortcut icon" href="{{landingPageImage('favicon','images/Pexeer.svg')}}/">
</head>

<body class="body-bg">
    <div class="auth-wrapper">
        @yield('content')
    </div>

<!-- js file start -->

<!-- JavaScript -->
<script src="{{asset('assets/common/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/common/js/popper.min.js')}}"></script>
<script src="{{asset('assets/common/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/common/js/metisMenu.min.js')}}"></script>
{{--toast message--}}
<script src="{{asset('assets/common/toast/vanillatoasts.js')}}"></script>
<script src="{{asset('assets/common/sweetalert/sweetalert.js')}}"></script>
{{-- Main js--}}
<script src="{{asset('assets/admin/js/main.js')}}"></script>

    <script>
        (function($) {
            "use strict";

            @if(session()->has('success'))
                swal({
                    text: '{{ session('success') }}',
                    icon: "success",
                    buttons: false,
                    timer: 3000,
                });

            @elseif(session()->has('dismiss'))
                swal({
                    text: '{{ session('dismiss') }}',
                    icon: "warning",
                    buttons: false,
                    timer: 3000,
                });

            @elseif($errors->any())
                @foreach($errors->getMessages() as $error)
                    swal({
                        text: '{{ $error[0] }}',
                        icon: "error",
                        buttons: false,
                        timer: 3000,
                    });
                @break
                @endforeach
            @endif

        })(jQuery);

    </script>
@yield('script')
<!-- End js file -->

</body>
</html>

