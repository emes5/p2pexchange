<section class="faq-two-area section" id="faq">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title faq-section-title">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title faq-section-subtitle">{{$section_parent->section_description}}</p>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="faq-accordion accordion" id="accordionFaq">
                    @foreach($section_data as $key=>$details)
                        <div class="accordion-item total-{{$active_page_id}} faq-details-view-{{$details->id}}">
                            <h2 class="accordion-header" id="heading{{$details->id}}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$details->id}}"
                                        aria-expanded="false" aria-controls="collapse{{$details->id}}">
                                    <span id="serial_number_{{$details->id}}">{{$key+1}}.</span> {{$details->question}}
                                </button>
                            </h2>
                            <div id="collapse{{$details->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$details->id}}" data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p>{{$details->answer}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
