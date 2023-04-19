;(function ($) {
    "use strict";

    /* sticky header */
    $(window).scroll(function () {

        if ($(window).scrollTop() > 150) {
            $('#is_sticky').addClass('is_sticky');
            $('.navbar-brand, .is_sticky .header-actions').addClass('d-block');
            $('.navbar-brand, .is_sticky .header-actions').removeClass('d-lg-none');
            $('.navbar-brand.sticky-logo').addClass('d-block');
        } else {
            $('#is_sticky').removeClass('is_sticky');
            $('.navbar-brand, #is_sticky .header-actions').addClass('d-lg-none');
            $('.navbar-brand, #is_sticky .header-actions').removeClass('d-block');
            $('.navbar-brand.sticky-logo').addClass('d-block');
        }
    });

    /* spy scroll/ walking menu */
    $('body').scrollspy({target: '#is_sticky'})


    $("#metismenu").metisMenu();

    $('.menu-bars').on('click', function () {
        $('.sidebar').toggleClass('sidebar-hide');
        $('.top-bar').toggleClass('content-expend');
        $('.main-wrapper').toggleClass('content-expend');
        $('.top-bar-logo').toggleClass('top-bar-logo-hide');
    });

    $(window).resize(function () {
        sidebarMenuCollpase();
    });

    function sidebarMenuCollpase() {
        if ($(window).width() <= 769) {

            $('.top-bar-logo').hide();
            $('.top-bar').addClass('content-expend');
            $('.main-wrapper').addClass('content-expend');
            $('.sidebar').addClass('sidebar-hide');

            $('.menu-bars').on('click', function () {
                $('.main-wrapper').toggleClass('content-expend');
            });

        }
        if ($(window).width() <= 426) {
            $('.top-bar-logo').show();
            $('.top-bar').addClass('content-expend');
            $('.main-wrapper').addClass('content-expend');
            $('.sidebar').addClass('sidebar-hide');

            $('.menu-bars').on('click', function () {
                $('.main-wrapper').toggleClass('content-expend');
            });
        }
    }

    sidebarMenuCollpase();


    $("#select-all").on('click', function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });


    /* Smooth scroll */
    $('a[href*="#"]:not([href="#"])').on('click', function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
    var testimonialSlider = $('.testimonial-slider');
    if (testimonialSlider.length) {
        testimonialSlider.owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            items: 1,
            navText: ['<i class="icofont-simple-left"></i>', '<i class="icofont-simple-right"></i>'],
        })
    }


    $('.card-header').on("click", function () {
        $(this).parent('.faq-card').toggleClass('card-open');
        $(this).parent('.faq-card').siblings().removeClass('card-open');
    });

    $('.navbar-toggler').on('click', function () {
        $('.navbar-collapse').toggleClass('menu-show');
    });

    var wow = new WOW(
        {
            boxClass: 'wow',      // animated element css class (default is wow)
            animateClass: 'animate__animated', // animation css class (default is animated)
            offset: 0,          // distance to the element when triggering the animation (default is 0)
            mobile: true,       // trigger animations on mobile devices (default is true)
            live: true,       // act on asynchronously loaded content (default is true)
            callback: function (box) {
                // the callback is fired every time an animation is started
                // the argument that is passed in is the DOM node being animated
            },
            scrollContainer: null,    // optional scroll container selector, otherwise use window,
            resetAnimation: true,     // reset animation on end (default is true)
        }
    );
    wow.init();


}(jQuery));
