<footer class="footer-area">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-widget about-widget">
                        <a href="{{route('home')}}" class="brand-logo"><img src="{{show_image(1,'logo')}}" alt="logo" /></a>
                        <p class="about-text">{{$settings['footer_description'] ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni nisi cumque delectus.'}}</p>
                        <ul class="social-media">
                            <li><a target="_blank" href="{{$settings['facebook_link'] ?? '#'}}"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a target="_blank" href="{{$settings['twitter_link'] ?? '#'}}"><i class="fab fa-twitter"></i></a></li>
                            <li><a target="_blank" href="{{$settings['linkedin_link'] ?? '#'}}"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a target="_blank" href="{{$settings['instagram_link'] ?? '#'}}"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-widget menu-widget">
                        <h3 class="widget-title">Features</h3>
                        <ul>
                            @foreach($footer_features as $feature)
                                @if($feature->footer_status)
                                    <li>{{$feature->sub_title}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-widget menu-widget">
                        <h3 class="widget-title">Services</h3>
                        <ul>
                            @foreach($custom_pages as $page)
                                @if(in_array($page->id,$selected_custom_pages))
                                    <li><a href="{{route('seeDetails',$page->key)}}">{{$page->title}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-widget address-widget">
                        <h3 class="widget-title">contact</h3>
                        <p>{{$settings['contact_address'] ?? '5055 North 03th Avenue,Penscola, FL 32503, New York'}}</p>
                        <ul class="content-links">
                            <li><i class="fas fa-phone-alt"></i>{{$settings['site_mobile'] ?? '+1 965 047 658 23'}}</li>
                            <li><i class="fas fa-envelope"></i>{{$settings['site_email'] ?? 'pexeercom54@gmail.com'}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="copyright-text text-center">{{$settings['copyright_text']}}</p>
        </div>
    </div>
</footer>
