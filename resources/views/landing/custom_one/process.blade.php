<section class="treading-process-area section-top pb-45">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="section-header-area text-center">
                    <h2 class="section-title">{{$section_parent->section_title}}</h2>
                    <p class="section-subtitle">{{$section_parent->section_description}}</p>
                </div>
            </div>
        </div>
        <div class="row">
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
