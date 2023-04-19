<section class="feature-area section-top pb-45" id="feature">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="section-header-area text-center">
                    <h2 class="section-title feature_title">{{$section_parent->section_title}}</h2>
                    <p class="section-subtitle feature_sub_title">{{$section_parent->section_description}}</p>
                </div>
            </div>
        </div>
        <div class="row feature-details-container">
            @foreach($section_data as $details)
                <div class="col-lg-4 col-md-6 feature-details-view-{{$details->id}}">
                    <div class="single-feature text-center">
                        <img class="feature-icon" src="{{check_storage_image_exists($details->icon)}}" alt="">
                        <h4 class="feature-title">{{$details->sub_title}}</h4>
                        <p class="feature-content">{{$details->sub_description}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
