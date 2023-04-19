<div class="feature-area{{$element_prefix}} section-bg-two section-top pb-90" id="feature">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title feature_title">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title feature_sub_title">{{$section_parent->section_description}}</p>
        </div>
        <div class="row feature-details-container">
            @foreach($section_data as $details)
                <div class="col-lg-4 col-md-6 feature-details-view-{{$details->id}}">
                    <div class="single-feature text-center">
                        <img class="feature-icon" src="{{check_storage_image_exists($details->icon)}}" alt="feature iocn" />
                        <h3 class="feature-title">{{$details->sub_title}}</h3>
                        <p class="feature-content">{{$details->sub_description}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
