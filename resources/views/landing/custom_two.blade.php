<!DOCTYPE html>
<html class="no-js" lang="en">
@include("landing.include.head")
<body id="home">
<header class="header-area{{$element_prefix}}" id="sticky">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{route('home')}}"><img src="{{show_image(1,'logo')}}" alt="logo" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav m-auto" id="nav">
                    <li class="nav-item current">
                        <a class="nav-link" href="{{route('home')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#trend">Trend</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feature">Feature</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-to-trade">How to Trade</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonial">Testimonial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">FAQ</a>
                    </li>
                </ul>
                <div class="navbar-right">
                    <div class="navbar-right-wrap">
                        @if(Auth::user())
                            <a @if(Auth::user()->role == USER_ROLE_USER) href="{{route('userDashboard')}}" @else href="{{route('adminDashboard')}}" @endif class="register-button">{{__('Dashboard')}}</a>
                        @else
                            <a href="{{route('login')}}" class="register-button">{{__('Sign in')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

@isset($blog)
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 mb-5">
                <h4>{{$content->title}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-5">
                {!! clean($content->description) !!}
            </div>
        </div>
    </div>
@else
@foreach($sections as $item)
    @if($item->section_status)
        @include('landing.'.$active_page_key.'.'.$item->section_key,['section_parent'=>$item,'section_data'=>$section_data[$item->section_key]])
    @endif
@endforeach
@endisset

@include("landing.$active_page_key.footer_area")
@include("landing.include.footer_assets")
{{--<script src="{{asset('assets/landing/custom/assets/js/chart.js')}}"></script>--}}
{{--<script src="{{asset('assets/landing/custom/assets/js/chart-active.js')}}"></script>--}}
</body>
</html>
