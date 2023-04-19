;(function($) {
    "use strict";

    $("#metismenu").metisMenu();

    $('.menu-bars').on('click', function() {
        $('.sidebar').toggleClass('sidebar-hide');
        $('.top-bar').toggleClass('content-expend');
        $('.main-wrapper').toggleClass('content-expend');
        $('.top-bar-logo').toggleClass('top-bar-logo-hide');
    });

    $(window).resize(function() {
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


    $("#select-all").on('click',function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('.number-only').on('keypress', function (e) {
        var regex = /^[+0-9+.\b]+$/;
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    $('.no-regx').on('keypress',function (e) {
        var regex = /^[a-zA-Z+0-9+\b]+$/;
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

}(jQuery));
