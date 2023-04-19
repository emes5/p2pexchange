<section class="features" id="feature">
    <div class="featrue-img">
        <div class="wow animate__fadeIn" data-wow-duration="500ms">
            <img
                @if(isset($settings['feature_section_img'])) src="{{asset(path_image().$settings['feature_section_img'])}}"
                @else
                src="{{asset('assets/landing/master/images/feature-img.png')}}" @endif class="img-fluid" alt="">
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title">
                    <h2 class="wow animate__fadeInUp"
                        data-wow-duration="500ms">{{ isset($settings['feature_section_title']) ? $settings['feature_section_title'] : "Know About Pexeer’s Feature" }}</h2>
                    <p class="wow animate__fadeInUp" data-wow-duration="700ms">{!! isset($settings['feature_section_des']) ? clean($settings['feature_section_des']) : 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque
                            mauris sit amet dignissim.' !!} </p>
                </div>
                <div class="feature-list" style="overflow: hidden">
                    <div class="row">
                        @if(isset($pexer_features[0]))
                            @foreach($pexer_features as $feature)
                                <div class="col-lg-6 col-md-6 col-12 mb-5">
                                    <h3>{{explode('|',$feature->slug)[1]}}</h3>
                                    <p> {!! clean($feature->value) !!} </p>
                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-6 col-md-6 col-12 mb-5 wow animate__fadeInLeft"
                                 data-wow-duration="500ms">
                                <h3>Various Ways To Pay</h3>
                                <p>Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat
                                    scelerisque mauris sit ame dignissim. </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-5 wow animate__fadeInRight"
                                 data-wow-duration="500ms">
                                <h3>No Middleman</h3>
                                <p>Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat
                                    scelerisque mauris sit ame dignissim. </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-5 wow animate__fadeInLeft"
                                 data-wow-duration="700ms">
                                <h3>Worldwide Service</h3>
                                <p>Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat
                                    scelerisque mauris sit ame dignissim. </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-5  wow animate__fadeInRight"
                                 data-wow-duration="700ms">
                                <h3>Encrypted Message</h3>
                                <p>Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat
                                    scelerisque mauris sit ame dignissim. </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-lg-0 mb-5 wow animate__fadeInLeft"
                                 data-wow-duration="900ms">
                                <h3>Fast Service</h3>
                                <p>Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat
                                    scelerisque mauris sit ame dignissim. </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 wow animate__fadeInRight" data-wow-duration="900ms">
                                <h3>Non-custodial</h3>
                                <p>Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat
                                    scelerisque mauris sit ame dignissim. </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
