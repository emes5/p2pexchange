<section class="how-to-trade-process-new">
    <article class="treading-process">
        <div class="arrow arrow-top wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/top-arrow.png')}}" class="img-fluid" alt="">
        </div>
        <div class="arrow arrow-bottom wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/bottom-arrow.png')}}" class="img-fluid" alt="">
        </div>
        <div class="arrow arrow-left wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/left-side-arrow.png')}}" class="img-fluid" alt="">
        </div>
        <div class="arrow arrow-right wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/right-side-arrow.png')}}" class="img-fluid" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="wow animate__fadeInUp section-title-process-main"
                            data-wow-duration="500ms"> {!! $section_parent->section_title !!} </h2>
                        <p class="wow animate__fadeInUp section-subtitle-process-main" data-wow-duration="700ms">
                            {!! $section_parent->section_description !!}
                        </p>
                    </div>
                </div>
            </div>

            @php
            $item = [];
                foreach($section_data as $xdata)
                {
                    $item[$xdata->serial] = (array)$xdata;
                }
            @endphp

            <div class="row justify-content-center">
                    <div class="col-lg-6 mb-5 wow animate__fadeInUp" data-wow-duration="1s">
                        <div class="treading-process-card">
                            <img src="{{check_storage_image_exists($item[4]['image'])}}" class="img-fluid image-process-4" alt="">
                            <div class="content">
                                <h4 class="mt-4 sub-title-process-4"> 4.{!! $item[4]['sub_title'] !!} </h4>
                                <p class="sub-description-process-4"> {!! $item[4]['sub_description'] !!} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-5 wow animate__fadeInUp" data-wow-duration="500ms">
                        <div class="treading-process-card">
                            <img src="{{check_storage_image_exists($item[1]['image'])}}" class="img-fluid image-process-1" alt="">
                            <div class="content">
                                <h4 class="mt-4 sub-title-process-1"> 1.{!! $item[1]['sub_title'] !!} </h4>
                                <p class="sub-description-process-1"> {!! $item[1]['sub_description'] !!} </p>
                            </div>
                        </div>
                    </div>
                <div class="col-lg-6 wow animate__fadeInUp" data-wow-duration="700ms">
                    <div class="treading-process-card">
                        <div class="content">
                            <h4 class="mt-4 sub-title-process-3"> 3.{!! $item[3]['sub_title'] !!} </h4>
                            <p class="sub-description-process-3"> {!! $item[3]['sub_description'] !!} </p>
                        </div>
                        <img src="{{check_storage_image_exists($item[3]['image'])}}" class="img-fluid image-process-3" alt="">
                    </div>
                </div>
                <div class="col-lg-6 wow animate__fadeInUp" data-wow-duration="900ms">
                    <div class="treading-process-card">
                        <div class="content">
                            <h4 class="mt-4 sub-title-process-2"> 2.{!! $item[2]['sub_title'] !!} </h4>
                            <p class="sub-description-process-2"> {!! $item[2]['sub_description'] !!} </p>
                        </div>
                        <img src="{{check_storage_image_exists($item[2]['image'])}}" class="img-fluid image-process-1" alt="">
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
