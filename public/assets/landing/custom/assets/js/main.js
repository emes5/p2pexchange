(function($) {
  "use strict";
  /*-------------------------------------------
  preloader active
  --------------------------------------------- */
  jQuery(window).on('load',function() {
    jQuery('.preloader').fadeOut('slow');
  });

  /*-------------------------------------------
  Sticky Header
  --------------------------------------------- */
  $(window).on('scroll', function(){
    if( $(window).scrollTop()>80 ){
      $('#sticky').addClass('stick');
    } else {
      $('#sticky').removeClass('stick');
    }
  });

  jQuery(document).ready(function(){
    /*-------------------------------------------
    js scrollup
    --------------------------------------------- */
    $.scrollUp({
      scrollText: '<i class="fa fa-angle-up"></i>',
      easingType: 'linear',
      scrollSpeed: 300,
      animation: 'fade'
    });
    /*-------------------------------------------
    testimonial-slide active
    --------------------------------------------- */
    $('.testimonial-slide').slick({
      infinite: true,
      speed: 500,
      slidesToShow: 2,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      dots: true,
      arrows: false,
      prevArrow: '<i class="slick-prev fas fa-angle-left"></i> ',
      nextArrow: '<i class="slick-next fas fa-angle-right"></i> ',
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
    /*-------------------------------------------
    testimonial-slide-two active
    --------------------------------------------- */
    $('.testimonial-slide-two').slick({
      infinite: true,
      speed: 500,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      dots: true,
      arrows: false,
      prevArrow: '<i class="slick-prev fas fa-angle-left"></i> ',
      nextArrow: '<i class="slick-next fas fa-angle-right"></i> ',
    });
    /*-------------------------------------------
    js onePageNav
    --------------------------------------------- */
    $('#nav').onePageNav({
      currentClass: 'current',
      changeHash: false,
      scrollSpeed: 300
    });
  /*-------------------------------------------
  collapse-btn
  --------------------------------------------- */
  $('.collapse-btn').on('click', function() {
      $(this).toggleClass('show');
      $('.dashbord-sidebar').toggleClass('hide');
      $('.main-content').toggleClass('active');
  });
  /*-------------------------------------------
    js niceSelect
    --------------------------------------------- */
  $('.wide').niceSelect();
  /*-------------------------------------------
  js dropify
  --------------------------------------------- */
  $('.dropify').dropify();



  });

})(jQuery);
