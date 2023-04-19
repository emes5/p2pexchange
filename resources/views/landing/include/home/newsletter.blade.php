<section class="newsletter wow animate__fadeIn" data-wow-duration="900ms">
    <div class="container">
        <div class="newsletter-inner">
            <div class="newsletter-img">
                <img
                    @if(isset($settings['newsletter_section_img'])) src="{{asset(path_image().$settings['newsletter_section_img'])}}"
                    @else
                    src="{{asset('assets/landing/master/images/newsletter-img.png')}}" @endif class="img-fluid" alt="">
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2>{!!  isset($settings['newsletter_section_title']) ? clean($settings['newsletter_section_title']) : 'Join Our Newsletter' !!}</h2>
                        <p>{!! isset($settings['newsletter_section_des']) ? clean($settings['newsletter_section_des']) : 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque
                                mauris sit amet dignissim.' !!} </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form class="newsletter-form" action="{{route('subscriptionProcess')}}" method="post">
                        @csrf
                        <input type="email" required name="email" class="form-control" placeholder="Your email">
                        <button type="submit" class="newsletter-submit-btn"><i class="icofont-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
