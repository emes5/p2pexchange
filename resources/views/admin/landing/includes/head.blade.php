<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{allsetting('app_title')}}</title>
    <meta name="description" content="Pexeer Responsive  HTML5 Template " />
    <meta name="keywords" content="business,corporate, creative, woocommerach, design, gallery, minimal, modern, landing page, cv, designer, freelancer, html, one page, personal, portfolio, programmer, responsive, nft, p2p, vcard, one page" />
    <meta name="author" content="{{allsetting('app_title')}}" />
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
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="{{landingPageImage('favicon','images/Pexeer.svg')}}">
    <!-- css file  -->
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/plugins.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/responsive.css')}}" />
    <script src="{{asset('assets/landing/custom/assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/landing/custom/assets/js/modernizr-3.11.2.min.js')}}"></script>
    <link href="{{asset('assets/landing/custom/assets/js/ladda/ladda-themeless.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/landing/custom/assets/js/sweetalert/sweetalert2.all.min.js')}}"></script>
    <link href="{{asset('assets/landing/custom/assets/js/sweetalert/sweetalert.css')}}" rel="stylesheet">
</head>
