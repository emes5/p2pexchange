<section class="testimonials" id="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2 class="wow animate__fadeInUp section-title-testimonial-main"
                        data-wow-duration="500ms">{{$section_parent->section_title}}</h2>
                    <p class="wow animate__fadeInUp section-subtitle-testimonial-main" data-wow-duration="700ms">{{$section_parent->section_description}}</p>
                </div>
            </div>
        </div>
        <div class="row wow animate__fadeIn" data-wow-duration="900ms">
            <div class="col-lg-12">
                <div class="owl-carousel owl-theme testimonial-slider testimonial-details-container">
                    @foreach($section_data as $details)
                        <div class="item testimonial-details-view-{{$details->id}}">
                            <div class="row align-items-center">
                                <div class="col-lg-4"><img src="{{check_storage_image_exists($details->image)}}" class="img-fluid testimonial-image" alt=""></div>
                                <div class="col-lg-6">
                                    <h3 class="testimonial-title">{{$details->sub_title}}</h3>
                                    <p class="testimonial-content">{{$details->sub_description}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<?php
