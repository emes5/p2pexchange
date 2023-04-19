<section class="team-area{{$element_prefix}} section-top pb-90">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title">{{$section_parent->section_description}}</p>
        </div>
        <div class="row">
            @foreach($section_data as $details)
                <div class="col-lg-4 col-md-6 team-details-view-{{$details->id}}">
                    <div class="single-team text-center">
                        <div class="team-image">
                            <img src="{{check_storage_image_exists($details->image)}}" alt="team-two-image" />
                            <div class="team-overlay">
                                <ul class="social-meida">
                                    <li><a href="{{$details->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="{{$details->twitter}}"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="{{$details->linkedin}}"><i class="fab fa-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <h3 class="team-name">{{$details->sub_title}}</h3>
                        <h4 class="team-designation">{{$details->sub_description}}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
