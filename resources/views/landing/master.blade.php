<!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{allsetting('app_title')}}"/>
    <meta property="og:image" content="{{show_image(1,'logo')}}">
    <meta property="og:site_name" content="{{allsetting('app_title')}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta itemprop="image" content="{{show_image(1,'logo')}}"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/bootstrap.min.css')}}">
    <!-- metismenu CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/metisMenu.min.css')}}">
    <!-- fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/icofont.min.css')}}">
    {{-- owl carousel --}}
    <link rel="stylesheet" href="{{asset('assets/common/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/owl.theme.default.min.css')}}">
    {{--for toast message--}}
    <link href="{{asset('assets/common/toast/vanillatoasts.css')}}" rel="stylesheet">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/landing/master/style.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('assets/landing/master/css/responsive.css')}}">
    <title>@yield('title') </title>
    <!-- Favicon and Touch Icons -->
    <link rel="shortcut icon" href="{{landingPageImage('favicon','images/Pexeer.svg')}}/">
    @yield('style')
</head>

<body class="body-bg" id="top"  data-spy="is_sticky">

<!-- header start-->
<header>
    <div class="header-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-6 col-6 order-lg-0 order-1">
                    <div class="header-actions text-left">
                        <a href="{{route('marketPlace')}}" class="btn cbtn1">{{__('Exchange')}}</a>
                    </div>
                </div>
                <div class="col-lg-4 col-12 order-lg-0 order-0 mb-lg-0 mb-4 d-lg-block d-none">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img src="{{show_image(1,'logo')}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-6 order-lg-0 order-2">
                    <div class="header-actions">
                        <a href="{{route('login')}}" class="btn cbtn1">{{__('Sign in')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end-->

    @include('landing.include.home.header');
    {{-- about section --}}
    @include('landing.include.home.about')
    {{-- about section --}}
    {{-- features --}}
    @include('landing.include.home.feature')
    {{-- features --}}
    {{-- how to trade --}}
    @include('landing.include.home.trade')
    {{-- how to trade --}}
    {{-- testimonials --}}
    @include('landing.include.home.testimonial')
    {{-- testimonials --}}
    {{-- faq --}}
    @include('landing.include.home.faq')
    {{-- faq --}}
    {{-- newsletter --}}
    @include('landing.include.home.newsletter')
    {{-- newsletter --}}

    <div class="modal fade " id="popUpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-content">
                                <p>
                                    @if(isset($settings['terms_condition']))
                                        {!! clean($settings['terms_condition']) !!}
                                    @else
                                        "Lorem ipsum dolor sit amet, consectetur adipisicing elit. A animi distinctio dolore
                                        ex, harum illum in inventore ipsam iusto laborum maiores minima minus modi nulla
                                        odio odit pariatur porro quod ratione reiciendis rerum tempore velit veritatis!
                                        Consequuntur corporis dolores ea eaque, error excepturi id ipsam iste magnam
                                        mollitia non nulla obcaecati placeat possimus provident quibusdam quod quos tempora.
                                        A autem cumque cupiditate, debitis distinctio, esse harum labore nobis nulla
                                        perferendis quasi tempora voluptas? Consequatur corporis cum reiciendis! A
                                        accusantium aperiam aspernatur at autem debitis delectus dolores error est eum
                                        eveniet ex facilis id itaque, laudantium magnam minima natus neque nihil nisi nobis
                                        numquam officiis perferendis quia quidem quisquam, repellendus reprehenderit saepe
                                        tempora ullam? Esse eum illum, neque obcaecati officiis quae repudiandae sequi. Aut
                                        corporis debitis dignissimos error, est fugit iste laboriosam laudantium maiores nam
                                        nobis quae quidem quod repellat repellendus rerum similique soluta voluptatem
                                        voluptates voluptatibus. Consequatur dolorem eos id illo numquam odit perspiciatis
                                        recusandae repudiandae suscipit unde. Aliquam, amet aperiam consequuntur corporis
                                        cum delectus dignissimos, ex, molestias obcaecati placeat quam quisquam quos rerum
                                        temporibus ut veritatis voluptates? Dolore facilis illum impedit natus quae?
                                        Accusantium adipisci asperiores atque cum delectus esse, eum ex illo in incidunt
                                        minima molestiae natus nemo neque nisi odio officiis possimus provident quae quaerat
                                        quas reiciendis rem repudiandae sint voluptas voluptate, voluptatem. Aspernatur,
                                        harum mollitia necessitatibus porro sit suscipit unde? Animi deleniti ducimus ea,
                                        eius harum ipsum magnam nesciunt officiis reiciendis vel! Aliquid atque deserunt
                                        fugit laborum qui quisquam saepe sapiente sequi vero voluptate. Aliquam aliquid
                                        consequatur culpa in incidunt odio quibusdam, temporibus voluptatibus. Alias aliquid
                                        commodi labore placeat tempora! Ad aperiam consequuntur, deserunt dolore eligendi
                                        magnam nisi pariatur quam quidem, repellat reprehenderit saepe sequi vero. Culpa
                                        debitis et minus modi nesciunt quidem, rem saepe? Accusantium at cumque enim
                                        exercitationem, optio pariatur provident quo veniam! Accusamus alias aliquam amet
                                        blanditiis consectetur cupiditate delectus deleniti deserunt distinctio dolor eaque
                                        esse excepturi exercitationem expedita illo inventore iure labore laudantium minus,
                                        necessitatibus non obcaecati odit optio pariatur perferendis possimus quae quidem
                                        quos repudiandae saepe sapiente sequi, sit, temporibus tenetur unde vel voluptatem.
                                        Aliquam autem consequuntur ducimus, earum eum eveniet excepturi inventore itaque
                                        labore laboriosam laborum necessitatibus nulla numquam porro quas qui ratione sed
                                        totam ut voluptatum? Corporis nostrum recusandae voluptas. Corporis iste quia rerum.
                                        Amet at autem beatae blanditiis consequatur culpa delectus dolor earum eligendi est
                                        exercitationem facere fuga fugit hic illo illum, ipsum iure modi molestiae,
                                        necessitatibus neque numquam porro praesentium quas quia quibusdam quos recusandae
                                        sit voluptatem voluptates? Accusamus accusantium alias architecto aspernatur
                                        assumenda at consectetur consequatur culpa cumque dolor earum eius eligendi enim
                                        error est ex illo incidunt maxime minus molestias nisi nulla quia quibusdam quos
                                        repellendus vel vero, voluptas! Animi aut blanditiis consequatur cumque cupiditate
                                        dicta dolor dolore dolores eaque earum excepturi facere, facilis hic impedit in ipsa
                                        ipsum iusto labore libero magnam modi necessitatibus nesciunt, nobis officia,
                                        placeat possimus quae quam qui quos repudiandae saepe totam voluptate voluptatum.
                                        Ratione, unde, vel! Aperiam aspernatur commodi ea et ex libero neque pariatur
                                        provident! Dolorem doloribus, minus."
                                    @endif
                                </p>
                            </div>
                            <div class="border-top pt-4">
                                <p>
                                    {{__('Please read this terms and condition carefully. It is necessary that you read and understand the information')}}
                                </p>
                            </div>
                            <form class="mt-4" action="{{route('saveUserAgreement')}}" method="POST">
                                @csrf
                                <div class="form-check">
                                    <input class="form-check-input d-none" type="radio" name="agree_terms"
                                           id="popupRadio1"
                                           value="{{AGREE}}">
                                    <label class="form-check-label" for="popupRadio1">{{__('Understand and Agree')}}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input d-none" type="radio" name="agree_terms"
                                           id="popupRadio2"
                                           value="{{NOT_AGREE}}">
                                    <label class="form-check-label" for="popupRadio2">{{__('Not agree')}}</label>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Close')}}</button>
                                    <button type="submit" class="btn theme-btn">{{__('Continue')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




{{--footer --}}
<footer class="footer">
    <div class="container">
        <div class="top-footer">
            <div class="row">
                <div class="col-lg-2 col-md-5 col-sm-6 order-lg-0 order-0 mb-lg-0 mb-5">
                    <div class="footer-widget">
                        <a href="#top" class="ftr-logo">
                            <img src="{{show_image(1,'logo')}}" class="img-fluid" alt="">
                        </a>
                        <ul class="social-links">
                            <li><a href="void:"><i class="icofont-behance"></i></a></li>
                            <li><a href="void:"><i class="icofont-dribbble"></i></a></li>
                            <li><a href="void:"><i class="icofont-twitter"></i></a></li>
                            <li><a href="void:"><i class="icofont-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 order-lg-0 order-2 mb-sm-0 mb-5">
                    <div class="footer-widget">
                        <p class="title">{{__('About')}}</p>
                        <p>
                            @if(isset($settings['about_section_des']))
                                {!! clean(\Illuminate\Support\Str::limit($settings['about_section_des'],150)) !!}
                            @else Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 order-lg-0 order-3 mb-sm-0 mb-5">
                    <div class="footer-widget">
                        <p class="title">{{__('Features')}}</p>
                        <ul class="links">
                            @if(isset($pexer_features[0]))
                                @foreach($pexer_features as $feature)
                                    <li>{{explode('|',$feature->slug)[1]}}</li>
                                @endforeach
                            @else
                                <li>Various Ways To Pay</li>
                                <li>No Middleman</li>
                                <li>Worldwide Service</li>
                                <li>Encrypted Message</li>
                                <li>Fast Service</li>
                                <li>Non-custodial</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 order-lg-0 order-1 mb-lg-0 mb-5">
                    <div class="footer-widget address-widget">
                        <p class="title">{{__('Contacts')}}</p>
                        <p>@if(isset($settings['company_address'])) {!! clean($settings['company_address']) !!}  @else 5055 North 03th Avenue,Penscola, FL 32503, New York @endif</p>
                        <ul class="content-links">
                            <li><i class="icofont-phone"></i>@if(isset($settings['company_mobile_no'])) {!! clean($settings['company_mobile_no']) !!} @else +1 965 047 658 23 @endif</li>
                            <li><i class="icofont-envelope"></i> @if(isset($settings['company_email_address'])) {!! clean($settings['company_email_address']) !!} @else pexeercom54@gmail.com @endif</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="bottom-footer">
            <p>{!! clean($settings['copyright_text']) !!}</p>
        </div>
    </div>
</footer>
{{--footer --}}

<!-- js file start -->

<!-- JavaScript -->
<script src="{{asset('assets/common/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/common/js/popper.min.js')}}"></script>
<script src="{{asset('assets/common/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/common/js/metisMenu.min.js')}}"></script>
{{--toast message--}}
<script src="{{asset('assets/common/toast/vanillatoasts.js')}}"></script>
<script src="{{asset('assets/common/sweetalert/sweetalert.js')}}"></script>
<script src="{{asset('assets/common/js/wow.min.js')}}"></script>
<script src="{{asset('assets/common/js/anime.min.js')}}"></script>
{{--owl--}}
<script src="{{asset('assets/common/js/owl.carousel.min.js')}}"></script>

<script src="{{asset('assets/landing/master/js/main.js')}}"></script>

<script>
    (function($) {
        "use strict";

        @if(session()->has('success'))
        swal({
            text: '{{ session('success') }}',
            icon: "success",
            buttons: false,
            timer: 3000,
        });

        @elseif(session()->has('dismiss'))
        swal({
            text: '{{ session('dismiss') }}',
            icon: "warning",
            buttons: false,
            timer: 3000,
        });

        @elseif($errors->any())
        @foreach($errors->getMessages() as $error)
        swal({
            text: '{{ $error[0] }}',
            icon: "error",
            buttons: false,
            timer: 3000,
        });
        @break
        @endforeach
        @endif

    })(jQuery);

</script>

<script>
    (function($) {
        "use strict";

        @if(Auth::user() && Auth::user()->agree_terms == STATUS_DEACTIVE)
        $(window).on('load', function () {
            $('#popUpModal').modal('show');
        });
        @endif

    })(jQuery);
</script>

<!-- End js file -->
</body>
</html>
