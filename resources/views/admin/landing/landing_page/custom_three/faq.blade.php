<section class="faq" id="faq">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2 class="wow animate__fadeInUp faq-section-title"
                        data-wow-duration="500ms">{{$section_parent->section_title}}</h2>
                    <p class="wow animate__fadeInUp faq-section-subtitle" data-wow-duration="700ms">{{$section_parent->section_description}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="faq-img">
                    <img src="{{asset('assets/landing/master/images/faq-left.png')}}"class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="faq-accordion accordion" id="faqAccordion">
                    @foreach($section_data as $key=>$details)
                        <div class="card faq-card wow animate__fadeInUp total-{{$active_page_id}} faq-details-view-{{$details->id}}" data-wow-duration="300ms">
                            <div class="card-header" id="faq{{$details->id}}">
                                <button class="btn btn-block collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapse{{$details->id}}" aria-expanded="false"
                                        aria-controls="collapse{{$details->id}}">
                                    {{$details->question}}
                                </button>
                            </div>
                            <div id="collapse{{$details->id}}" class="collapse" aria-labelledby="faq{{$details->id}}"
                                 data-parent="#faqAccordion">
                                <div class="card-body">
                                    {{$details->answer}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
