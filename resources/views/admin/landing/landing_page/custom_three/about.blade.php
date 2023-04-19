<section class="about" id="about">
    <div class="left-img wow animate__fadeIn about-image-three" data-wow-duration="500ms">
        <img src="{{check_storage_image_exists($section_data[0]->image)}}" class="img-fluid" alt="">
    </div>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-6 col-md-12 col-12">
                <div class="right-content">
                    <h2 class="wow animate__fadeInUp about-title"
                        data-wow-duration="500ms">{{$section_parent->section_title}}</h2>
                    <p class="wow animate__fadeInUp about-subtitle" data-wow-duration="500ms">{{$section_parent->section_description}}</p>
                    <p class="wow animate__fadeInUp about-long-subtitle" data-wow-duration="500ms">{{$section_data[0]->long_description}}</p>
                    <a href="{{route('marketPlace')}}" class="btn theme-btn wow animate__fadeInUp"
                       data-wow-duration="500ms">
                        {{__('Go the Marketplace ')}}
                        <img src="{{asset('assets/landing/master/images/arrow-right.svg')}}" class="img-fluid btn-arrow"
                             alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
