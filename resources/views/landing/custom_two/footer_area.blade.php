<footer class="footer-area{{$element_prefix}}">
    <div class="widget-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
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
                <div class="col-lg-3 col-md-6">
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
                <div class="col-lg-3 col-md-6">
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
                <div class="col-lg-3 col-md-6">
                    <div class="single-widget newsletter-widget">
                        <h3 class="widget-title">{{__('newsletter')}}</h3>
                        <p>{{$settings['newsletter_description'] ?? 'Subscribe to our weekly newsletter and receive updates vai email'}}</p>
                        <div class="newsletter-form">
                            <form action="{{route('subscriptionProcess')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
                                    <button type="submit" class="send-btn"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-start">
                    {{--                    <p class="copyright-text">Copyright &copy; 2022</p>--}}
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <p class="copyright-text">{{$settings['copyright_text']}}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="{{asset('assets/common/sweetalert/sweetalert.js')}}"></script>
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
