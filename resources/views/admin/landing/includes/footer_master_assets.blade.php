{{--<script src="{{asset('assets/common/js/jquery.min.js')}}"></script>--}}
<script src="{{asset('assets/landing/custom/assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/common/js/popper.min.js')}}"></script>
<script src="{{asset('assets/landing/custom/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/common/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/common/js/metisMenu.min.js')}}"></script>
{{--toast message--}}
<script src="{{asset('assets/common/toast/vanillatoasts.js')}}"></script>
<script src="{{asset('assets/common/sweetalert/sweetalert.js')}}"></script>
<script src="{{asset('assets/common/js/wow.min.js')}}"></script>
<script src="{{asset('assets/common/js/anime.min.js')}}"></script>
{{--owl--}}
<script src="{{asset('assets/common/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/landing/custom/assets/js/plugins.js')}}"></script>
<script src="{{asset('assets/landing/master/js/main.js')}}"></script>
<script src="{{asset('assets/landing/custom/assets/js/LaraframeScript.js')}}"></script>
<script src="{{asset('assets/landing/custom/assets/js/crud.js')}}"></script>
<script src="{{asset('assets/landing/custom/assets/js/ladda/spin.min.js')}}"></script>
<script src="{{asset('assets/landing/custom/assets/js/ladda/ladda.min.js')}}"></script>
<script src="{{asset('assets/landing/custom/assets/js/ladda/ladda.jquery.min.js')}}"></script>
<script>
    /*-------------------------------------------
  collapse-btn
  --------------------------------------------- */
    $('.collapse-btn').on('click', function() {
        $(this).toggleClass('show');
        $('.dashbord-sidebar').toggleClass('hide');
        $('.main-content').toggleClass('active');
    });
    /*-------------------------------------------
    js dropify
    --------------------------------------------- */
    $('.dropify').dropify();

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
            //$('#popUpModal').modal('show');
        });
        @endif

    })(jQuery);
</script>
