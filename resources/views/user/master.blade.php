<!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="The Highly Secured Bitcoin Wallet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{allsetting('app_title')}}"/>
    <meta property="og:image" content="{{show_image(2,'logo')}}">
    <meta property="og:site_name" content="{{allsetting('app_title')}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="{{allsetting('app_title')}}"/>
    <meta itemscope itemtype="{{ url()->current() }}/{{allsetting('app_title')}}" />
    <meta itemprop="headline" content="{{allsetting('app_title')}}" />
    <meta itemprop="image" content="{{show_image(2,'logo')}}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/bootstrap.min.css')}}">
    <!-- metismenu CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/metisMenu.min.css')}}">
    {{--for toast message--}}
    <link href="{{asset('assets/common/toast/vanillatoasts.css')}}" rel="stylesheet" >
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('assets/common/css/datatable/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/datatable/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/datatable/dataTables.jqueryui.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/datatable/jquery.dataTables.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/common/css/jquery.scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/common/css/jquery.countdown.css')}}">

    {{--    dropify css  --}}
    <link rel="stylesheet" href="{{asset('assets/common/dropify/dropify.css')}}">
    {{--    for search with tag--}}
    <link href="{{asset('assets/common/multiselect/tokenize2.css')}}" rel="stylesheet">
    {{--    phone number code css--}}
    <link rel="stylesheet" href="{{asset('assets/common/input_master_telephone/build/css/intlTelInput.css')}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/user/style.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('assets/user/css/responsive.css')}}">
    <!-- select -->
    <link rel="stylesheet" href="{{asset('assets/common/multiselect/bootstrap-select.min.css')}}">
    @if(isset(allsetting()['google_recapcha']) && allsetting()['google_recapcha'])
        {!! NoCaptcha::renderJs() !!}
    @endif
    @yield('style')
    <title>{{allsetting('app_title')}}::@yield('title')</title>
    <!-- Favicon and Touch Icons -->
    <link rel="shortcut icon" href="{{landingPageImage('favicon','images/Pexeer.svg')}}">
</head>

<body class="cp-user-body-bg">
<!-- header-top -->
<div class="header-middle">
    <div class="container-fuild">
        <div class="row align-items-center">
            <div class="col-5 col-md-2 col-xl-1">
                <div class="cp-user-logo">
                    <a href="{{route('userDashboard')}}">
                        <img src="{{show_image(1,'logo')}}" class="img-fluid cp-user-logo-large" alt="">
                    </a>
                </div>
            </div>
            @if(Auth::user())
                @php
                    $notifications = \App\Model\Notification::where(['user_id'=> Auth::user()->id, 'status' => 0])->orderBy('id', 'desc')->get();
                @endphp
            @endif
            <div class="col-2 d-xl-none d-block">
                <div class="cp-user-sidebar-toggler">
                    <img src="{{asset('assets/user/images/menu.svg')}}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-md-8 col-xl-10 d-none d-xl-block">
                <nav>
                    <ul>
                        <li class="@if(isset($menu) && $menu == 'dashboard') cp-user-active-page @endif">
                            <a href="{{route('userDashboard')}}">
                                    <span class="cp-user-icon">
                                        <img src="{{asset('assets/user/images/sidebar-icons/dashboard.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                        <img src="{{asset('assets/user/images/sidebar-icons/hover/dashboard.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                                    </span>
                                <span class="cp-user-name">{{__('Dashboard')}}</span>
                            </a>
                        </li>
                        <li class="@if(isset($menu) && $menu == 'pocket') cp-user-active-page @endif">
                            <a href="{{route('myPocket')}}">
                                    <span class="cp-user-icon">
                                        <img src="{{asset('assets/user/images/sidebar-icons/Wallet.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                        <img src="{{asset('assets/user/images/sidebar-icons/hover/Wallet.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                                    </span>
                                <span class="cp-user-name">{{__('My Wallet')}}</span>
                            </a>
                        </li>
                        <li class="@if(isset($menu) && $menu == 'marketplace') cp-user-active-page @endif">
                            <a href="{{route('marketPlace')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/002-Crypto-exchange-1.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/002-Crypto-exchange.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                                <span class="cp-user-name">{{__('Crypto Exchange')}}</span>
                            </a>
                        </li>
                        <li class="@if(isset($menu) && $menu == 'offer') cp-user-active-page @endif">
                            <a href="{{route('myOffer')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/My-Offer-1.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/Offer.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                                <span class="cp-user-name">{{__('My Offer')}}</span>
                            </a>
                        </li>
                        <li class=" @if(isset($menu) && $menu == 'trade') cp-user-active-page @endif">
                            <a href="{{route('myTradeList')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/Trade-1.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/Trade-1.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                                <span class="cp-user-name">{{__('My Trade List')}}</span>
                            </a>
                        </li>
                        @if(admin_feature_enable('buy_coin_feature'))
                            <li class="@if(isset($menu) && $menu == 'buy_coin') cp-user-active-page mm-active @endif">
                                <a class="arrow-icon" href="#" aria-expanded="true">
                                    <span class="cp-user-icon">
                                        <img src="{{asset('assets/user/images/sidebar-icons/icon.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                        <img src="{{asset('assets/user/images/sidebar-icons/hover/icon.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                                    </span>
                                    <span class="cp-user-name">{{__('Buy Coin')}}</span>
                                </a>
                                <ul class="@if(isset($menu) && $menu == 'buy_coin')  mm-show  @endif">
                                    <li class="@if(isset($sub_menu) && $sub_menu == 'buy_coin') cp-user-submenu-active @endif">
                                        <a href="{{route('buyCoinPage')}}">{{__('Buy Coin')}}</a>
                                    </li>
                                    <li class="@if(isset($sub_menu) && $sub_menu == 'buy_coin_history') cp-user-submenu-active @endif">
                                        <a href="{{route('buyCoinHistory')}}">{{__('Buy Coin History')}}</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="@if(isset($menu) && $menu == 'referral') cp-user-active-page @endif">
                            <a href="{{route('myReferral')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/004-share-1.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/004-share.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                                <span class="cp-user-name">{{__('My Referral')}}</span>
                            </a>
                        </li>
                        <li class="@if(isset($menu) && $menu == 'setting') cp-user-active-page mm-active @endif">
                            <a class="arrow-icon" href="#" aria-expanded="true">
                                <span class="cp-user-icon">
                                    <img src="{{asset('assets/user/images/sidebar-icons/settings.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                    <img src="{{asset('assets/user/images/sidebar-icons/hover/settings.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                                </span>
                                <span class="cp-user-name">{{__('Settings')}}</span>
                            </a>
                            <ul class="@if(isset($menu) && $menu == 'setting')  mm-show  @endif">
                                <li class="@if(isset($sub_menu) && $sub_menu == 'setting') cp-user-submenu-active @endif">
                                    <a href="{{route('userSetting')}}">{{__('My Settings')}}</a>
                                </li>
                                <li class="@if(isset($sub_menu) && $sub_menu == 'faq') cp-user-submenu-active @endif">
                                    <a href="{{route('userFaq')}}">{{__('FAQ')}}</a>
                                </li>
                            </ul>
                        </li>
                        @if(empty(Auth::user()))
                            <li class="">
                                <a href="{{route('login')}}">
                                    <span class="cp-user-icon">
                                        <img src="{{asset('assets/admin/images/sidebar-icons/user.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                        <img src="{{asset('assets/admin/images/sidebar-icons/user.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                                    </span>
                                    <span class="cp-user-name">{{__('Login')}}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            <div class="col-5 col-md-8 col-xl-1">
                <div class="cp-user-top-bar-right">
                    <ul>
                        <li class="hm-notify" id="notification_item">
                            <div class="btn-group dropdown">
                                <button type="button" class="btn notification-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="notify-value hm-notify-number">@if(isset($notifications) && ($notifications ->count() > 0)) {{ $notifications->count() }} @else 0 @endif</span>
                                    <img src="{{ asset('assets/img/icons/notification.png') }}" class="img-fluid" alt="">
                                </button>
                                @if(isset($notifications[0]))
                                    <div class="dropdown-menu notification-list dropdown-menu-right">
                                        <div class="text-center p-2 border-bottom nt-title">{{__('New Notifications')}}</div>
                                        <ul class="scrollbar-inner">
                                            @foreach($notifications as $item)
                                                <li>
                                                    <a href="javascript:void(0);" data-toggle="modal" data-id="{{$item->id}}" data-target="#notificationShow" class="dropdown-item viewNotice">
                                                        <span class="small d-block">{{ date('d M y', strtotime($item->created_at)) }}</span>
                                                        {!! clean($item->title) !!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="dropdown-menu notification-list dropdown-menu-right">
                                        <div class="text-center p-2 border-bottom nt-title">{{__('No New Notification Found')}}</div>
                                    </div>
                                @endif
                            </div>
                        </li>
                        <li>
                            @if(Auth::user())
                            <div class="btn-group profile-dropdown">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="cp-user-avater">
                                        <span class="cp-user-img">
                                            <img src="{{show_image(Auth::user()->id,'user')}}" class="img-fluid" alt="">
                                        </span>
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <span class="big-user-thumb">
                                        <img src="{{show_image(Auth::user()->id,'user')}}" class="img-fluid" alt="">
                                    </span>
                                    <div class="user-name">
                                        <p>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</p>
                                    </div>
                                    <button class="dropdown-item" type="button"><a href="{{route('userProfile')}}"><i class="fa fa-user-circle-o"></i> {{__('Profile')}}</a></button>
                                    <button class="dropdown-item" type="button"><a href="{{route('userSetting')}}"><i class="fa fa-cog"></i> {{__('My Settings')}}</a></button>
                                    <button class="dropdown-item" type="button"><a href="{{route('myPocket')}}"><i class="fa fa-credit-card"></i> {{__('My Wallet')}}</a></button>
                                    <button class="dropdown-item" type="button"><a href="{{route('logOut')}}"><i class="fa fa-sign-out"></i> {{__('Logout')}}</a></button>
                                </div>
                            </div>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- header-top -->

<!-- sidebar menu -->
<div class="cp-user-sidebar">
    <div class="mb-sidebar-toggler">
        <img src="{{asset('assets/user/images/menu.svg')}}" class="img-fluid" alt="">
    </div>
    <div class="cp-user-sidebar-menu scrollbar-inner">
        <nav>
            <ul id="metismenu">
                <li class="@if(isset($menu) && $menu == 'dashboard') cp-user-active-page @endif">
                    <a href="{{route('userDashboard')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/dashboard.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/dashboard.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                        <span class="cp-user-name">{{__('Dashboard')}}</span>
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'pocket') cp-user-active-page @endif">
                    <a href="{{route('myPocket')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/Wallet.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/Wallet.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                        <span class="cp-user-name">{{__('My Wallet')}}</span>
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'marketplace') cp-user-active-page @endif">
                    <a href="{{route('marketPlace')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/002-Crypto exchange-1.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/002-Crypto exchange-1.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                        <span class="cp-user-name">{{__('Crypto Exchange')}}</span>
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'offer') cp-user-active-page @endif">
                    <a href="{{route('myOffer')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/My-Offer-1.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/Offer.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                        <span class="cp-user-name">{{__('My Offer')}}</span>
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'trade') cp-user-active-page @endif">
                    <a href="{{route('myTradeList')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/Trade-1.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/Trade-1.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                        <span class="cp-user-name">{{__('My Trade List')}}</span>
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'referral') cp-user-active-page @endif">
                    <a href="{{route('myReferral')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/004-share-1.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/004-share-1.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                        <span class="cp-user-name">{{__('My Referral')}}</span>
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'profile') cp-user-active-page @endif">
                    <a href="{{route('userProfile')}}">
                            <span class="cp-user-icon">
                                <img src="{{asset('assets/user/images/sidebar-icons/user.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                                <img src="{{asset('assets/user/images/sidebar-icons/hover/user.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                            </span>
                        <span class="cp-user-name">{{__('Profile')}}</span>
                    </a>
                </li>
                <li class="@if(isset($menu) && $menu == 'setting') cp-user-active-page mm-active @endif">
                    <a class="arrow-icon" href="#" aria-expanded="true">
                        <span class="cp-user-icon">
                            <img src="{{asset('assets/user/images/sidebar-icons/settings.svg')}}" class="img-fluid cp-user-side-bar-icon" alt="">
                            <img src="{{asset('assets/user/images/sidebar-icons/hover/settings.svg')}}" class="img-fluid cp-user-side-bar-icon-hover" alt="">
                        </span>
                        <span class="cp-user-name">{{__('Settings')}}</span>
                    </a>
                    <ul class="@if(isset($menu) && $menu == 'setting')  mm-show  @endif">
                        <li class="@if(isset($sub_menu) && $sub_menu == 'setting') cp-user-submenu-active @endif">
                            <a href="{{route('userSetting')}}">{{__('My Settings')}}</a>
                        </li>
                        <li class="@if(isset($sub_menu) && $sub_menu == 'faq') cp-user-submenu-active @endif">
                            <a href="{{route('userFaq')}}">{{__('FAQ')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

{{--notification modal--}}

<div class="modal fade" id="notificationShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content dark-modal">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{__('New Notification')}}  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="hm-form">
                    <div class="row">
                        <div class="col-12">
                            <h6 id="n_title"></h6>
                            <p id="n_date"></p>
                            <p id="n_notice"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main wrapper -->
<div class="cp-user-main-wrapper">
    <div class="container-fluid">
        <div class="alert alert-success alert-dismissible fade show d-none" role="alert" id="web_socket_notification">
            <span id="socket_message"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @yield('content')
    </div>
</div>
<!-- /main wrapper -->
@include('cookie-accept');
<!-- JavaScript -->
<script src="{{asset('assets/common/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/common/js/popper.min.js')}}"></script>
<script src="{{asset('assets/common/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/common/js/metisMenu.min.js')}}"></script>
{{--toast message--}}
<script src="{{asset('assets/common/toast/vanillatoasts.js')}}"></script>
<script src="{{asset('assets/common/sweetalert/sweetalert.js')}}"></script>
<!-- Datatable -->
<script src="{{asset('assets/common/js/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/common/js/datatable/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/common/js/datatable/dataTables.jqueryui.min.js')}}"></script>
<script src="{{asset('assets/common/js/datatable/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('assets/common/js/jquery.scrollbar.min.js')}}"></script>

<script src="{{asset('assets/common/js/jquery.plugin.min.js')}}"></script>
<script src="{{asset('assets/common/js/jquery.countdown.min.js')}}"></script>

{{--dropify--}}
<script src="{{asset('assets/common/dropify/dropify.js')}}"></script>
<script src="{{asset('assets/common/dropify/form-file-uploads.js')}}"></script>
{{--for select--}}
<script src="{{asset('assets/common/multiselect/bootstrap-select.min.js')}}"></script>

<script src="{{asset('assets/common/tagsinput/bootstrap-tagsinput.css')}}"></script>
<script src="{{asset('assets/common/tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('assets/user/js/main.js')}}"></script>

{{--    for search with tag--}}
<script src="{{asset('assets/common/multiselect/tokenize2.js')}}"></script>
{{-- for web sockets--}}
<script src="https://js.pusher.com/3.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.8.1/echo.iife.min.js"></script>

<script>
    (function($) {
        "use strict";
        // pusher config

        let my_env_socket_port = "{{ env('BROADCAST_PORT')}}";
        Pusher.logToConsole = true;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            wsHost: window.location.hostname,
            wsPort: my_env_socket_port,
            wssPort: 443,
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: 'mt1',
            encrypted: false,
            disableStats: true
        });


        @if(Auth::user())

            Pusher.logToConsole = true;

            Echo.channel('usernotification_' + '{{Auth::id()}}')
                .listen('.receive_notification', (data) => {

                    if (data.success == true) {
                        let message = data.message;
                        $('#web_socket_notification').removeClass('d-none');
                        $('#socket_message').html(message);

                        $.ajax({
                            type: "GET",
                            url: '{{ route('getNotification') }}',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'user_id': data.user_id,
                            },
                            success: function (datas) {

                                $('#notification_item').html(datas.data);
                                swal({
                                    text: data.message,
                                    icon: "success",
                                    buttons: false,
                                    timer: 3000,
                                });
                            }
                        });
                    }
                });
        @endif


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

        $(document).ready(function() {
            $('.cp-user-custom-table').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering:  true,
                select: false,
                bDestroy: true
            });
        });

        $(document).on('click', '.viewNotice', function (e) {
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: '{{ route('showNotification') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id,
                },
                success: function (data) {
                    $("#n_title").text(data['data']['title']);
                    $("#n_date").text(data['data']['date']);
                    $("#n_notice").text(data['data']['notice']);
                    $('#notification_item').html(data['data']['html'])
                }
            });
        });

    })(jQuery);
</script>

<!-- End js file -->
@yield('script')
</body>
</html>

