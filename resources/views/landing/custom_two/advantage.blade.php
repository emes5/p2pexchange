<section class="cash-crypto-today section-top pb-90">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title">{{$section_parent->section_description}}</p>
        </div>
        <div class="row">
            @foreach($section_data as $key=>$details)
                <div class="col-lg-3 col-md-6 advantage-details-view-{{$details->id}}">
                    <div class="single-card text-center">
                        <div class="card-icon">
                            <img src="{{check_storage_image_exists($details->image)}}">
                        </div>
                        <h3 class="card-title">{{$details->sub_title}}</h3>
                        <p class="card-content">{{$details->sub_description}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
