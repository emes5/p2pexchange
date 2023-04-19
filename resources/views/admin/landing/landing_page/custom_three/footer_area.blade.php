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
                            <li><a href="void:"><i class="icofont-behance"></i></a></li>
                            <li><a href="void:"><i class="icofont-dribbble"></i></a></li>
                            <li><a href="void:"><i class="icofont-twitter"></i></a></li>
                            <li><a href="void:"><i class="icofont-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 order-lg-0 order-2 mb-sm-0 mb-5">
                    <div class="footer-widget">
                        <p class="title">{{__('About')}}</p>
                        <p>
                            @if(isset($settings['about_section_des']))
                                {!! clean(\Illuminate\Support\Str::limit($settings['about_section_des'],150)) !!}
                            @else Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 order-lg-0 order-3 mb-sm-0 mb-5">
                    <div class="footer-widget">
                        <p class="title">{{__('Features')}}</p>
                        <ul class="links">
                            @if(isset($pexer_features[0]))
                                @foreach($pexer_features as $feature)
                                    <li>{{explode('|',$feature->slug)[1]}}</li>
                                @endforeach
                            @else
                                <li>Various Ways To Pay</li>
                                <li>No Middleman</li>
                                <li>Worldwide Service</li>
                                <li>Encrypted Message</li>
                                <li>Fast Service</li>
                                <li>Non-custodial</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 order-lg-0 order-1 mb-lg-0 mb-5">
                    <div class="footer-widget address-widget">
                        <p class="title">{{__('Contacts')}}</p>
                        <p>@if(isset($settings['company_address'])) {!! clean($settings['company_address']) !!}  @else 5055 North 03th Avenue,Penscola, FL 32503, New York @endif</p>
                        <ul class="content-links">
                            <li><i class="icofont-phone"></i>@if(isset($settings['company_mobile_no'])) {!! clean($settings['company_mobile_no']) !!} @else +1 965 047 658 23 @endif</li>
                            <li><i class="icofont-envelope"></i> @if(isset($settings['company_email_address'])) {!! clean($settings['company_email_address']) !!} @else pexeercom54@gmail.com @endif</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="bottom-footer">
            <p>{!! 'Copyright © 2022' !!}</p>
        </div>
    </div>
</footer>
