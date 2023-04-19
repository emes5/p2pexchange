
<section class="testimonial-two-area section section-bg-two" id="testimonial">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title">{{$section_parent->section_description}}</p>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="testimonial-slide-two">
                    @foreach($section_data as $details)
                        <div class="single-testimonial testimonial-details-view-{{$details->id}}">
                            <img class="testimonial-image" src="{{check_storage_image_exists($details->image)}}" alt="testimonial-image" />
                            <div class="quote-icon">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <p class="testimonial-content">{{$details->sub_description}}</p>
                            <h4 class="testimonial-profession">{{$details->sub_title}}</h4>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $('.testimonial-slide-two').slick({
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true,
        arrows: false,
        prevArrow: '<i class="slick-prev fas fa-angle-left"></i> ',
        nextArrow: '<i class="slick-next fas fa-angle-right"></i> ',
    });
</script>
