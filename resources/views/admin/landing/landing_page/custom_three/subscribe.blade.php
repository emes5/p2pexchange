<section class="newsletter wow animate__fadeIn" data-wow-duration="900ms">
    <div class="container">
        <div class="newsletter-inner">
            <div class="newsletter-img">
                <img src="{{asset('assets/landing/master/images/newsletter-img.png')}}" class="img-fluid" alt="">
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2 class="subscribe-section-title-main">{{$section_parent->section_title}}</h2>
                        <p class="subscribe-section-subtitle-main">{{$section_parent->section_description}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form class="newsletter-form" action="#" method="post">
                        <input type="email" required name="email" class="form-control" placeholder="Your email">
                        <button type="submit" class="newsletter-submit-btn"><i class="icofont-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
