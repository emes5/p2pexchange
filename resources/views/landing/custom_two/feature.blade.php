<div class="feature-area{{$element_prefix}} section-bg-two section-top pb-90" id="feature">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title">{{$section_parent->section_description}}</p>
        </div>
        <div class="row">
            @foreach($section_data as $details)
                <div class="col-lg-4 col-md-6 feature-details-view-{{$details->id}}">
                    <div class="single-feature">
                        <div class="feature-icon">
                            <img src="{{check_storage_image_exists($details->icon)}}" alt="feature iocn" />
                        </div>
                        <h3 class="feature-title">{{$details->sub_title}}</h3>
                        <p class="feature-content">{{$details->sub_description}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
