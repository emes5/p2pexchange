<header>
    <div class="header-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-6 col-6 order-lg-0 order-1">
                    <div class="header-actions text-left">
                        <a href="{{route('marketPlace')}}" class="btn cbtn1">{{__('Exchange')}}</a>
                    </div>
                </div>
                <div class="col-lg-4 col-12 order-lg-0 order-0 mb-lg-0 mb-4 d-lg-block d-none">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img src="{{show_image(1,'logo')}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-6 order-lg-0 order-2">
                    <div class="header-actions">
                        @if(Auth::user())
                            <a @if(Auth::user()->role == USER_ROLE_USER) href="{{route('userDashboard')}}" @else href="{{route('adminDashboard')}}" @endif class="btn cbtn1">{{__('Dashboard')}}</a>
                        @else
                            <a href="{{route('login')}}" class="btn cbtn1">{{__('Sign in')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@foreach($sections as $item)
    <div class="{{$item->section_key}}-section" @if(!$item->section_status) style="display: none" @endif>
        @include('admin.landing.landing_page.'.$active_page_key.'.'.$item->section_key,['section_parent'=>$item,'section_data'=>$section_data[$item->section_key]])
    </div>
@endforeach

<footer class="footer">
    <div class="container">
        <div class="top-footer">
            <div class="row">
                <div class="col-lg-2 col-md-5 col-sm-6 order-lg-0 order-0 mb-lg-0 mb-5">
                    <div class="footer-widget">
                        <a href="#top" class="ftr-logo">
                            <img src="{{show_image(1,'logo')}}" class="img-fluid" alt="">
                        </a>
                        <ul class="social-links">
                            <li><a href="{{$settings['facebook_link'] ?? '#'}}"><i class="icofont-facebook"></i></a></li>
                            <li><a href="{{$settings['twitter_link'] ?? '#'}}"><i class="icofont-twitter"></i></a></li>
                            <li><a href="{{$settings['linkedin_link'] ?? '#'}}"><i class="icofont-linkedin"></i></a></li>
                            <li><a href="{{$settings['instagram_link'] ?? '#'}}"><i class="icofont-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 order-lg-0 order-2 mb-sm-0 mb-5">
                    <div class="footer-widget">
                        <p class="title">{{__('About')}}</p>
                        <p>{{$settings['footer_description'] ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni nisi cumque delectus.'}}</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 order-lg-0 order-3 mb-sm-0 mb-5">
                    <div class="footer-widget">
                        <p class="title">{{__('Features')}}</p>
                        <ul class="links">
                            @foreach($footer_features as $feature)
                                @if($feature->footer_status)
                                    <li>{{$feature->sub_title}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 order-lg-0 order-1 mb-lg-0 mb-5">
                    <div class="footer-widget address-widget">
                        <p class="title">{{__('Contacts')}}</p>
                        <p>{{$settings['contact_address'] ?? '5055 North 03th Avenue,Penscola, FL 32503, New York'}}</p>
                        <ul class="content-links">
                            <li><i class="icofont-phone"></i>{{$settings['site_mobile'] ?? '+1 965 047 658 23'}}</li>
                            <li><i class="icofont-envelope"></i>{{$settings['site_email'] ?? 'pexeercom54@gmail.com'}}</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="bottom-footer">
            <p>{{$settings['copyright_text']}}</p>
        </div>
    </div>
</footer>
