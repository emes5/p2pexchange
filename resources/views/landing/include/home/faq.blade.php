<section class="faq" id="faq">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2 class="wow animate__fadeInUp"
                        data-wow-duration="500ms">{{isset($settings['faq_section_title']) ? $settings['faq_section_title'] : 'What Want Our Customer'}}</h2>
                    <p class="wow animate__fadeInUp" data-wow-duration="700ms">{!! isset($settings['faq_section_des']) ? clean($settings['faq_section_des']) : 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque
                            mauris sit amet dignissim.'  !!} </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="faq-img">
                    <img
                        @if(isset($settings['faq_section_img'])) src="{{asset(path_image().$settings['faq_section_img'])}}"
                        @else
                        src="{{asset('assets/landing/master/images/faq-left.png')}}" @endif class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="accordion" id="faqAccordion">
                    @php
                        $i =0
                    @endphp
                    @if(isset($faqs[0]))
                        @foreach($faqs as $faq)
                            @php
                                if($i > 3) $i = 1; else
                                  $i += 1
                            @endphp
                            <div class="card faq-card wow animate__fadeInUp" data-wow-duration="{{rand(2,5)}}s">
                                <div class="card-header" id="faq{{$faq->id}}">
                                    <button class="btn btn-block collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapse{{$faq->id}}"
                                            aria-expanded="false"
                                            aria-controls="collapse1">
                                        {!! clean($faq->question) !!}
                                    </button>
                                </div>

                                <div id="collapse{{$faq->id}}" class="collapse" aria-labelledby="faq{{$faq->id}}"
                                     data-parent="#faqAccordion">
                                    <div class="card-body">
                                        {!! clean($faq->answer) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card faq-card wow animate__fadeInUp" data-wow-duration="300ms">
                            <div class="card-header" id="faq1">
                                <button class="btn btn-block collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapse1" aria-expanded="false"
                                        aria-controls="collapse1">
                                    Can we use for trial?
                                </button>
                            </div>

                            <div id="collapse1" class="collapse" aria-labelledby="faq1"
                                 data-parent="#faqAccordion">
                                <div class="card-body">
                                    Beguiled and demoralized by the charms of pleasure of moment, so blinded by
                                    desire,
                                    that they cannot foresee the pain trouble that are bound to ensue; and equal
                                    blame
                                    belongs to those who fail in their duty through.Beguiled and demoralized by the
                                    charms.Beguiled and demoralized by the charms of pleasure of moment, so blinded
                                    by
                                    desire, that they cannot foresee the pain trouble
                                </div>
                            </div>
                        </div>
                        <div class="card faq-card wow animate__fadeInUp" data-wow-duration="400ms">
                            <div class="card-header" id="faq2">
                                <button class="btn btn-block collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapse2" aria-expanded="false"
                                        aria-controls="collapse2">
                                    Can we use for trial?
                                </button>
                            </div>

                            <div id="collapse2" class="collapse" aria-labelledby="faq2"
                                 data-parent="#faqAccordion">
                                <div class="card-body">
                                    Beguiled and demoralized by the charms of pleasure of moment, so blinded by
                                    desire,
                                    that they cannot foresee the pain trouble that are bound to ensue; and equal
                                    blame
                                    belongs to those who fail in their duty through.Beguiled and demoralized by the
                                    charms.Beguiled and demoralized by the charms of pleasure of moment, so blinded
                                    by
                                    desire, that they cannot foresee the pain trouble
                                </div>
                            </div>
                        </div>
                        <div class="card faq-card wow animate__fadeInUp" data-wow-duration="500ms">
                            <div class="card-header" id="faq3">
                                <button class="btn btn-block collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapse3" aria-expanded="false"
                                        aria-controls="collapse3">
                                    When our power of choice is untrammelled?
                                </button>
                            </div>

                            <div id="collapse3" class="collapse" aria-labelledby="faq3"
                                 data-parent="#faqAccordion">
                                <div class="card-body">
                                    Beguiled and demoralized by the charms of pleasure of moment, so blinded by
                                    desire,
                                    that they cannot foresee the pain trouble that are bound to ensue; and equal
                                    blame
                                    belongs to those who fail in their duty through.Beguiled and demoralized by the
                                    charms.Beguiled and demoralized by the charms of pleasure of moment, so blinded
                                    by
                                    desire, that they cannot foresee the pain trouble
                                </div>
                            </div>
                        </div>
                        <div class="card faq-card wow animate__fadeInUp" data-wow-duration="600ms">
                            <div class="card-header" id="faq5">
                                <button class="btn btn-block collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapse5" aria-expanded="false"
                                        aria-controls="collapse5">
                                    Who do not know how to pursue pleasure?
                                </button>
                            </div>

                            <div id="collapse5" class="collapse" aria-labelledby="faq5"
                                 data-parent="#faqAccordion">
                                <div class="card-body">
                                    Beguiled and demoralized by the charms of pleasure of moment, so blinded by
                                    desire,
                                    that they cannot foresee the pain trouble that are bound to ensue; and equal
                                    blame
                                    belongs to those who fail in their duty through.Beguiled and demoralized by the
                                    charms.Beguiled and demoralized by the charms of pleasure of moment, so blinded
                                    by
                                    desire, that they cannot foresee the pain trouble
                                </div>
                            </div>
                        </div>
                        <div class="card faq-card wow animate__fadeInUp" data-wow-duration="700ms">
                            <div class="card-header" id="faq6">
                                <button class="btn btn-block collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapse6" aria-expanded="false"
                                        aria-controls="collapse6">
                                    Who do not know how to pursue pleasure?
                                </button>
                            </div>

                            <div id="collapse6" class="collapse" aria-labelledby="faq6"
                                 data-parent="#faqAccordion">
                                <div class="card-body">
                                    Beguiled and demoralized by the charms of pleasure of moment, so blinded by
                                    desire,
                                    that they cannot foresee the pain trouble that are bound to ensue; and equal
                                    blame
                                    belongs to those who fail in their duty through.Beguiled and demoralized by the
                                    charms.Beguiled and demoralized by the charms of pleasure of moment, so blinded
                                    by
                                    desire, that they cannot foresee the pain trouble
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
