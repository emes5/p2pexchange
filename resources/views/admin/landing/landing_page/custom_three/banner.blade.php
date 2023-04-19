<div class="hero-section">
    <div class="navigation-menu" id="is_sticky">
        <div class="container">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a href="{{route('home')}}" class="navbar-brand d-lg-none">
                        <img src="{{show_image(1,'logo')}}" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item"><a class="nav-link active" href="#top">{{__('Home')}}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#about">{{__('About')}}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#feature">{{__('Feature')}}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#how-to-trade">{{__('How to Trade')}}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#testimonial">{{__('Testimonial')}}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#faq">{{__('FAQ')}}</a></li>
                        </ul>
                    </div>
                    <div class="header-actions ml-auto d-none">
                        <a href="{{route('login')}}" class="btn cbtn1">{{__('Sign in')}}</a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="left-content">
                    <h5>{!! 'Peer to Peer Trading' !!}</h5>
                    <h2 class="hero-title">{{$section_parent->section_title}}</h2>
                    <p class="hero-content">
                        {{$section_parent->section_description}}
                    </p>
                    <a href="{{route('marketPlace')}}" class="btn theme-btn">
                        {{__('Go the Marketplace')}}
                        <img src="{{asset('assets/landing/master/images/arrow-right.svg')}}" alt=""
                             class="img-fluid btn-arrow">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <img src="{{asset('assets/landing/master/images/cerve-line.svg')}}" alt="" class="cerve-line">
    <div class="right-image">
        <div class="hero-img-dot-1">
            <img src="{{asset('assets/landing/master/images/hero-dots/e1.png')}}" class="img-fluid" alt="">
        </div>
        <div class="hero-img-dot-2">
            <img src="{{asset('assets/landing/master/images/hero-dots/e2.png')}}" class="img-fluid" alt="">
        </div>
        <div class="hero-img-dot-3">
            <img src="{{asset('assets/landing/master/images/hero-dots/e3.png')}}" class="img-fluid" alt="">
        </div>
        <div class="hero-img-dot-4">
            <img src="{{asset('assets/landing/master/images/hero-dots/e4.png')}}" class="img-fluid" alt="">
        </div>
{{--        <img class="img-fluid" src="{{asset('assets/landing/master/images/content-right-img.png')}}" alt="">--}}
        <img class="img-fluid hero-banner-area" src="{{check_storage_image_exists($section_data[0]->image)}}" alt="">
    </div>
</div>
