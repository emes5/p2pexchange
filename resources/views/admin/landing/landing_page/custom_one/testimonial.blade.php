<section class="testimonial-area section" id="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="section-header-area text-center">
                    <h2 class="section-title section-title-testimonial-main">{{$section_parent->section_title}}</h2>
                    <p class="section-subtitle section-subtitle-testimonial-main">{{$section_parent->section_description}}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slide testimonial-details-container">
            @foreach($section_data as $details)
                <div class="single-testimonial testimonial-details-view-{{$details->id}}">
                    <img class="testimonial-image" src="{{check_storage_image_exists($details->image)}}" alt="testimonial-image" />
                    <h3 class="testimonial-title">{{$details->sub_title}}</h3>
                    <p class="testimonial-content">{{$details->sub_description}}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
<script type="text/javascript">
    $('.testimonial-slide').slick({
        infinite: true,
        speed: 500,
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true,
        arrows: false,
        prevArrow: '<i class="slick-prev fas fa-angle-left"></i> ',
        nextArrow: '<i class="slick-next fas fa-angle-right"></i> ',
    });
</script>
