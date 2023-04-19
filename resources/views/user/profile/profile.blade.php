@extends('user.master',['menu'=>'profile'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">

            <ul class="nav cp-user-profile-nav" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{($qr == 'profile-tab') ? 'active' : ''}}" data-id="profile-tab"
                       id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                       aria-controls="pills-profile" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/profile.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/profile.svg')}}"
                                         class="img-fluid img-active" alt="">
                                </span>
                        {{__('Profile')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{($qr == 'eProfile-tab') ? 'active' : ''}}" data-id="eProfile-tab"
                       id="pills-edit-profile-tab" data-toggle="pill" href="#pills-edit-profile" role="tab"
                       aria-controls="pills-edit-profile" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/edit-profile.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/edit-profile.svg')}}"
                                         class="img-fluid img-active" alt=""
                                    ></span>
                        {{__('Edit Profile')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{($qr == 'pvarification-tab') ? 'active' : ''}}" data-id="pvarification-tab"
                       id="pills-phone-verify-tab" data-toggle="pill" href="#pills-phone-verify" role="tab"
                       aria-controls="pills-phone-verify" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/phone-verify.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/phone-verify.svg')}}"
                                         class="img-fluid img-active" alt=""
                                    ></span>
                        {{__('Phone Verification')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{($qr == 'idvarification-tab') ? 'active' : ''}}" data-id="idvarification-tab"
                       id="pills-id-verify-tab" data-toggle="pill" href="#pills-id-verify" role="tab"
                       aria-controls="pills-id-verify" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/id-verify.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/id-verify.svg')}}"
                                         class="img-fluid img-active" alt="">
                                </span>
                        {{__('KYC')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{($qr == 'rpassword-tab') ? 'active' : ''}}" data-id="rpassword-tab"
                       id="pills-reset-pass-tab" data-toggle="pill" href="#pills-reset-pass" role="tab"
                       aria-controls="pills-id-verify" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/reset-pass.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/reset-pass.svg')}}"
                                         class="img-fluid img-active" alt="">
                                </span>
                        {{__('Reset Password')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{($qr == 'activity-tab') ? 'active' : ''}}" data-id="activity-tab"
                       id="pills-activity-log-tab" data-toggle="pill" href="#pills-activity-log" role="tab"
                       aria-controls="pills-id-verify" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/activity-log.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/activity-log.svg')}}"
                                         class="img-fluid img-active" alt=""
                                    >
                                </span>
                        {{__('Activity')}}
                    </a>
                </li>
            </ul>
            <div class="tab-content cp-user-profile-tab-content" id="pills-tabContent">
                <div class="tab-pane fade show {{($qr == 'profile-tab') ? 'show active in' : ''}}" id="pills-profile"
                     role="tabpanel" aria-labelledby="pills-profile-tab">
                    @include('user.profile.include.profile')
                </div>
                <div class="tab-pane fade {{($qr == 'eProfile-tab') ? 'show active in' : ''}}" id="pills-edit-profile"
                     role="tabpanel" aria-labelledby="pills-edit-profile-tab">
                    @include('user.profile.include.edit_profile')
                </div>
                <div class="tab-pane fade {{($qr == 'pvarification-tab') ? 'show active in' : ''}}"
                     id="pills-phone-verify" role="tabpanel" aria-labelledby="pills-phone-verify-tab">
                    @include('user.profile.include.phone')
                </div>
                <div class="tab-pane fade {{($qr == 'idvarification-tab') ? 'show active in' : ''}}"
                     id="pills-id-verify" role="tabpanel" aria-labelledby="pills-id-verify-tab">
                    @include('user.profile.include.kyc')
                </div>
                <div class="tab-pane fade {{($qr == 'rpassword-tab') ? 'show active in' : ''}}" id="pills-reset-pass"
                     role="tabpanel" aria-labelledby="pills-reset-pass-tab">
                    @include('user.profile.include.password')
                </div>
                <div class="tab-pane fade {{($qr == 'activity-tab') ? 'show active in' : ''}}" id="pills-activity-log"
                     role="tabpanel" aria-labelledby="pills-activity-log-tab">
                    @include('user.profile.include.activity')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade cp-user-idverifymodal" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('assets/user/images/close.svg')}}" class="img-fluid"
                                                      alt=""></span>
                    </button>
                    <form id="nidUpload" class="Upload" action="{{route('nidUpload')}}" enctype="multipart/form-data"
                          method="post">
                        @csrf
                        <div class="container">
                            <div class="row">

                                <div class="col-12">
                                    <div class="card-list">
                                        <div class="alert alert-danger d-none error_msg" id="" role="alert">
                                        </div>
                                        <div class="alert alert-success d-none succ_msg" id="" role="alert">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-lg-0 mb-4">
                                    <div class="idcard">
                                        <h3 class="title">{{__('Front Side')}}</h3>
                                        <div id="file-upload" class="section-p">
                                            @if((empty($nid_back ) && empty($nid_front)) || (($nid_back->status == STATUS_REJECTED) && ($nid_front->status == STATUS_REJECTED)))
                                                <input type="file" accept="image/x-png,image/jpeg" name="file_two"
                                                       id="file" ref="file" class="dropify"
                                                       @if(!empty($nid_front) && (!empty($nid_front->photo)))  data-default-file="{{asset(IMG_USER_VIEW_PATH.$nid_front->photo)}}" @endif />
                                            @else
                                                <div class="card-inner">
                                                    <img src="{{asset(IMG_USER_VIEW_PATH.$nid_front->photo)}}"
                                                         class="img-fluid" alt="">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-lg-0 mb-4">
                                    <div class="idcard">
                                        <h3 class="title">{{__('Back Side')}}</h3>
                                        @if((empty($nid_back ) && empty($nid_front)) || (($nid_back->status == STATUS_REJECTED) && ($nid_front->status == STATUS_REJECTED)))
                                            <input type="file" accept="image/x-png,image/jpeg" name="file_three"
                                                   id="file" ref="file" class="dropify"
                                                   @if(!empty($nid_back) && (!empty($nid_back->photo)))  data-default-file="{{asset(IMG_USER_VIEW_PATH.$nid_back->photo)}}" @endif />
                                        @else
                                            <div class="card-inner">
                                                <img src="{{asset(IMG_USER_VIEW_PATH.$nid_back->photo)}}"
                                                     class="img-fluid" alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if((empty($nid_back ) && empty($nid_front)) || (($nid_back->status == STATUS_REJECTED) && ($nid_front->status == STATUS_REJECTED)))
                                    <div class="col-12">
                                        <button type="submit" class="btn carduploadbtn">{{__('Upload')}}</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade cp-user-passwordverifymodal" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('assets/user/images/close.svg')}}" class="img-fluid"
                                                      alt=""></span>
                    </button>
                    <form id="nidUpload" class="Upload" action="{{route('passUpload')}}" enctype="multipart/form-data"
                          method="post">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-list">
                                        <div class="alert alert-danger d-none error_msg" id="" role="alert">
                                        </div>
                                        <div class="alert alert-success d-none succ_msg" id="" role="alert">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-lg-0 mb-4">
                                    <div class="idcard">
                                        <h3 class="title">{{__('Front Side')}}</h3>
                                        <div id="file-upload" class="section-p">
                                            @if((empty($pass_back ) && empty($pass_front)) || (($pass_back->status == STATUS_REJECTED) && ($pass_front->status == STATUS_REJECTED)))
                                                <input type="file" accept="image/x-png,image/jpeg" name="file_two"
                                                       id="file" ref="file" class="dropify"
                                                       @if(!empty($pass_front) && (!empty($pass_front->photo)))  data-default-file="{{asset(IMG_USER_VIEW_PATH.$pass_front->photo)}}" @endif />
                                            @else
                                                <div class="card-inner">
                                                    <img src="{{asset(IMG_USER_VIEW_PATH.$pass_front->photo)}}"
                                                         class="img-fluid" alt="">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-lg-0 mb-4">
                                    <div class="idcard">
                                        <h3 class="title">{{__('Back Side')}}</h3>
                                        @if((empty($pass_back ) && empty($pass_front)) || (($pass_back->status == STATUS_REJECTED) && ($pass_front->status == STATUS_REJECTED)))
                                            <input type="file" accept="image/x-png,image/jpeg" name="file_three"
                                                   id="file" ref="file" class="dropify"
                                                   @if(!empty($pass_back) && (!empty($pass_back->photo)))  data-default-file="{{asset(IMG_USER_VIEW_PATH.$pass_back->photo)}}" @endif />
                                        @else
                                            <div class="card-inner">
                                                <img src="{{asset(IMG_USER_VIEW_PATH.$pass_back->photo)}}"
                                                     class="img-fluid" alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if((empty($pass_back ) && empty($pass_front)) || (($pass_back->status == STATUS_REJECTED) && ($pass_front->status == STATUS_REJECTED)))
                                    <div class="col-12">
                                        <button type="submit" class="btn carduploadbtn">{{__('Upload')}}</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade cp-user-driververifymodal" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('assets/user/images/close.svg')}}" class="img-fluid"
                                                      alt=""></span>
                    </button>
                    <form id="nidUpload" class="Upload" action="{{route('driveUpload')}}" enctype="multipart/form-data"
                          method="post">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-list">
                                        <div class="alert alert-danger d-none error_msg" id="" role="alert">
                                        </div>
                                        <div class="alert alert-success d-none succ_msg" id="" role="alert">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-lg-0 mb-4">
                                    <div class="idcard">
                                        <h3 class="title">{{__('Front Side')}}</h3>
                                        <div id="file-upload" class="section-p">
                                            @if((empty($drive_back ) && empty($drive_front)) || (($drive_back->status == STATUS_REJECTED) && ($drive_front->status == STATUS_REJECTED)))
                                                <input type="file" accept="image/x-png,image/jpeg" name="file_two"
                                                       id="file" ref="file" class="dropify"
                                                       @if(!empty($drive_front) && (!empty($drive_front->photo)))  data-default-file="{{asset(IMG_USER_VIEW_PATH.$drive_front->photo)}}" @endif />
                                            @else
                                                <div class="card-inner">
                                                    <img src="{{asset(IMG_USER_VIEW_PATH.$drive_front->photo)}}"
                                                         class="img-fluid" alt="">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-lg-0 mb-4">
                                    <div class="idcard">
                                        <h3 class="title">{{__('Back Side')}}</h3>
                                        @if((empty($drive_back ) && empty($drive_front)) || (($drive_back->status == STATUS_REJECTED) && ($drive_front->status == STATUS_REJECTED)))
                                            <input type="file" accept="image/x-png,image/jpeg" name="file_three"
                                                   id="file" ref="file" class="dropify"
                                                   @if(!empty($drive_back) && (!empty($drive_back->photo)))  data-default-file="{{asset(IMG_USER_VIEW_PATH.$drive_back->photo)}}" @endif />
                                        @else
                                            <div class="card-inner">
                                                <img src="{{asset(IMG_USER_VIEW_PATH.$drive_back->photo)}}"
                                                     class="img-fluid" alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if((empty($drive_back ) && empty($drive_front)) || (($drive_back->status == STATUS_REJECTED) && ($drive_front->status == STATUS_REJECTED)))
                                    <div class="col-12">
                                        <button type="submit" class="btn carduploadbtn">{{__('Upload')}}</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $('.nav-link').on('click', function () {
            var query = $(this).data('id');
            window.history.pushState('page2', 'Title', '{{route('userProfile')}}?qr=' + query);
        });

        jQuery("#upload-user-img").on('change', function () {
            this.form.submit();
        });

        $(function () {
            $(document.body).on('submit', '.Upload', function (e) {
                e.preventDefault();
                $('.error_msg').addClass('d-none');
                $('.succ_msg').addClass('d-none');
                var form = $(this);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: form.attr('action'),
                    data: new FormData($(this)[0]),
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.success == true) {
                            $('.succ_msg').removeClass('d-none');
                            $('.succ_msg').html(data.message);

                            $(".succ_msg").fadeTo(2000, 500).slideUp(500, function () {
                                $(".succ_msg").slideUp(500);
                            });
                        } else {
                            $('.error_msg').removeClass('d-none');
                            $('.error_msg').html(data.message);

                            $(".error_msg").fadeTo(2000, 500).slideUp(500, function () {
                                $(".error_msg").slideUp(500);
                            });
                        }
                    }
                });
                return false;
            });
        });

        $(".reveal").on('click', function () {
            var $pwd = $(".show-pass");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });

        $(".reveal-1").on('click', function () {
            var $pwd = $(".show-pass-1");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });
        $(".reveal-2").on('click', function () {
            var $pwd = $(".show-pass-2");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });

        $(".toggle-password").on('click', function () {
            $(this).toggleClass("fa-eye-slash fa-eye");
        });

        function showHidePassword(id) {

            var x = document.getElementById(id);
            if (x.type === "password") {
                x.type = "text";

            } else {
                x.type = "password";
            }
        }

        function readURL(input, img) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + img).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document.body).on('click', '#password_btn', function () {
            console.log($('#password').input.type);
        });

        $(document.body).on('click', '.iti__country', function () {
            var cd = $(this).find('.iti__dial-code').html();
            $('#code_v').val(cd)
        });

        $('#activity-tbl').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: '{{route('userProfile')}}',
            order: [3, 'desc'],
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "action", "orderable": false},
                {"data": "source", "orderable": false},
                {"data": "ip_address", "orderable": false},
                {"data": "updated_at", "orderable": true},
            ],
        });
    </script>
@endsection
