<!-- about area start here  -->
<section class="about-area section" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="about-info">
                    <h2 class="about-title">{{$section_parent->section_title}}</h2>
                    <h4 class="about-subtitle">{{$section_parent->section_description}}</h4>
                    <p class="about-long-subtitle">{{$section_data[0]->long_description}}</p>
                    <a href="{{$section_data[0]->button_link}}" class="primary-btn">{{$section_data[0]->button_name}}</a>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="about-image">
                    <img src="{{check_storage_image_exists($section_data[0]->image)}}" alt="secure-trading" />
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about area end here  -->
