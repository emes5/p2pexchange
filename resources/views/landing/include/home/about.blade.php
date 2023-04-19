<section class="about" id="about">
    <div class="left-img wow animate__fadeIn" data-wow-duration="500ms">
        <img @if(isset($settings['about_section_img'])) src="{{asset(path_image().$settings['about_section_img'])}}"
             @else
             src="{{asset('assets/landing/master/images/about-img.png')}}" @endif class="img-fluid" alt="">
    </div>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-6 col-md-12 col-12">
                <div class="right-content">
                    <h2 class="wow animate__fadeInUp"
                        data-wow-duration="500ms">{!! isset($settings['about_section_title']) ? clean($settings['about_section_title']) : 'Why You Will Choose Pexeer For Your Trading?' !!} </h2>
                    @if(isset($settings['about_section_des']))
                        <p class="wow animate__fadeInUp"
                           data-wow-duration="500ms">{!! clean($settings['about_section_des']) !!} </p>
                    @else
                        <p class="wow animate__fadeInUp" data-wow-duration="500ms">Aenean condimentum nibh vel enim
                            sodales scelerisque. Mauris quisn pellentesque odio, in
                            vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum
                            accumsan
                            nisl vulputate.</p>
                        <p class="wow animate__fadeInUp" data-wow-duration="500ms">Cenenatis. Suspendisse est nulla,
                            sollicitudin eget viverra quis, mo quis tortor. Fusce
                            ac
                            lacus ut nisl hendrerit mximus. Intege scsque molestie molestie. Suspendse eleifend urna
                            at
                            euismod ornare. Mauris dolosem, scelerisque eleifend dolor nec, ornare laoreet
                            velit.</p>
                        <p class="wow animate__fadeInUp" data-wow-duration="500ms">Aenean condimentum nibh vel enim
                            sodales scelerisque. Mauris quis pellentesque odio, in
                            vulputate turpis. Integer condimentum enim quis lorem pellentesque euismod. Nam rutrum
                            acc
                            venenatis. Suspendisse est nulla, sollicitudin eget viverra quis, mollis quis
                            tortor.</p>
                    @endif
                    <a href="{{route('marketPlace')}}" class="btn theme-btn wow animate__fadeInUp"
                       data-wow-duration="500ms">
                        {{__('Go the Marketplace ')}}
                        <img src="{{asset('assets/landing/master/images/arrow-right.svg')}}" class="img-fluid btn-arrow"
                             alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
