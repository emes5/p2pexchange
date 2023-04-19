<section class="features" id="feature">
    <div class="featrue-img">
        <div class="wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/feature-img.png')}}" class="img-fluid" alt="">
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title">
                    <h2 class="wow animate__fadeInUp feature_title"
                        data-wow-duration="500ms">{{$section_parent->section_title}}</h2>
                    <p class="wow animate__fadeInUp feature_sub_title" data-wow-duration="700ms">{{$section_parent->section_description}}</p>
                </div>
                <div class="feature-list row feature-details-container" style="overflow: hidden">
                    @foreach($section_data as $details)
                        <div class="col-lg-6 col-md-6 col-12 mb-5 wow animate__fadeInLeft feature-details-view-{{$details->id}}" data-wow-duration="500ms">
                            <div class="single-feature">
                                <h3 class="feature-title">{{$details->sub_title}}</h3>
                                <p class="feature-content">{{$details->sub_description}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
