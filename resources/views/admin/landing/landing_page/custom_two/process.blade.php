<section class="treading-process-two section section-bg-two">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title section-title-process-main">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title section-subtitle-process-main">{{$section_parent->section_description}}</p>
        </div>
        <div class="row process-details-container">
            @foreach($section_data as $key=>$details)
                <div class="col-lg-4 col-md-6 process-details-view-{{$details->id}}">
                    <div class="single-process">
                        <span class="process-count">{{$key+1}}</span>
                        <img class="process-icon" src="{{check_storage_image_exists($details->image)}}" alt="process" />
                        <h3 class="process-title">{{$details->sub_title}}</h3>
                        <p class="process-content">{{$details->sub_description}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{--<div class="col-lg-4 col-md-6 process-details-view-{{$details->id}}">--}}
{{--    <div class="single-process">--}}
{{--        <span class="process-stype">{{$details->serial}}</span>--}}
{{--        <img class="process-image" src="{{check_storage_image_exists($details->image)}}" alt="process" />--}}
{{--        <h3 class="process-title">{{$details->sub_title}}</h3>--}}
{{--        <p class="process-content">{{$details->sub_description}}</p>--}}
{{--    </div>--}}
{{--</div>--}}
