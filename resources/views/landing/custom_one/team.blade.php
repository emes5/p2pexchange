<section class="team-area section-top pb-45">
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
            @foreach($section_data as $details)
                <div class="col-lg-4 col-md-6 team-details-view-{{$details->id}}">
                    <div class="single-team text-center">
                        <div class="team-image"><a href="javascript:void(0)"><img src="{{check_storage_image_exists($details->image)}}" alt="team image" /></a></div>
                        <h3 class="team-name"><a href="#">{{$details->sub_title}}</a></h3>
                        <p class="team-info">{{$details->sub_description}}</p>
                        <ul class="social-media">
                            <li><a href="{{$details->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="{{$details->linkedin}}"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="{{$details->twitter}}"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
