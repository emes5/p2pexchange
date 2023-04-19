<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{allsetting('app_title')}}</title>
    <meta name="description" content="{{allsetting('app_title')}}" />
    <meta name="keywords" content="business,corporate, creative, woocommerach, design, gallery, minimal, modern, landing page, cv, designer, freelancer, html, one page, personal, portfolio, programmer, responsive, nft, p2p, vcard, one page" />
    <meta name="author" content="{{allsetting('app_title')}}" />
    <meta property="og:image" content="{{show_image(1,'logo')}}">
    <meta property="og:site_name" content="{{allsetting('app_title')}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta itemprop="image" content="{{show_image(1,'logo')}}"/>
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="{{landingPageImage('favicon','images/Pexeer.svg')}}">
    <!-- css file  -->
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/plugins.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/bootstrap.min.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/landing/custom/assets/css/responsive.css')}}" type="text/css" />
    <script src="{{asset('assets/landing/custom/assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/landing/custom/assets/js/modernizr-3.11.2.min.js')}}"></script>
</head>
<style>
    :root {
        --primary-color{{$element_prefix}}: {{$main_primary_color}};
        --hover-color{{$element_prefix}}: {{$main_hover_color}};
    }
</style>
@if(isset($settings['font_enable']) && $settings['font_enable'])
    @if(!empty($settings['font_file_name']))
        <style>
            @font-face {
                font-family: "My font";
                font-style: normal;
                font-weight: 400;
                font-display: block;
                src: url({{asset('assets/landing/custom/assets/fonts/'.$settings['font_file_name'])}});
                src: url({{asset('assets/landing/custom/assets/fonts/'.$settings['font_file_name'])}}) format("truetype");
            }
            :root {
                --primary-font: "My font";
            }
        </style>
    @endif
@endif
