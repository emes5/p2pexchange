<section class="faq-area section" id="faq">
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
            <div class="col-lg-8 offset-lg-2">
                <div class="faq-accordion accordion accordion-flush" id="FaqAccordion">
                    @foreach($section_data as $key=>$details)
                        <div class="accordion-item faq-details-view-{{$details->id}}">
                            <h2 class="accordion-header" id="flush-heading-{{$details->id}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$details->id}}" aria-expanded="false" aria-controls="flush-collapse-{{$details->id}}">
                                    <span>{{$key+1}}.</span> {{$details->question}}
                                </button>
                            </h2>
                            <div id="flush-collapse-{{$details->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$details->id}}" data-bs-parent="#FaqAccordion">
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
