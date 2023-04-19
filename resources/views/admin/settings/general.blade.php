@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'general'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Settings')}}</li>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management">
        <div class="row">
            <div class="col-12">
                <ul class="nav user-management-nav mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='general') active @endif nav-link " id="pills-user-tab"
                           data-toggle="pill" data-controls="general" href="#general" role="tab"
                           aria-controls="pills-user" aria-selected="true">
                            <span>{{__('General Settings')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='email') active @endif nav-link " id="pills-add-user-tab"
                           data-toggle="pill" data-controls="email" href="#email" role="tab"
                           aria-controls="pills-add-user" aria-selected="true">
                            <span>{{__('Email Settings')}} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='sms') active @endif nav-link " id="pills-sms-tab"
                           data-toggle="pill" data-controls="sms" href="#sms" role="tab" aria-controls="pills-sms"
                           aria-selected="true">
                            <span>{{__('Twillo Settings')}} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='referral') active @endif nav-link "
                           id="pills-suspended-user-tab" data-toggle="pill" data-controls="referral" href="#referral"
                           role="tab" aria-controls="pills-suspended-user" aria-selected="true">
                            <span>{{__('Referral Settings')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='payment') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="payment" href="#payment" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('Coin Payment Settings')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='default') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="default" href="#default" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('Default Coin Settings')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='terms') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="terms" href="#terms" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('Privacy Policy')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='kyc') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="kyc" href="#kyc" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('KYC Setting')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='chart') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="chart" href="#chart" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('Chart Setting')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='font') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="font" href="#font" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('Font Setting')}}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show @if(isset($tab) && $tab=='general')  active @endif" id="general"
                         role="tabpanel" aria-labelledby="pills-user-tab">
                        @include('admin.settings.setting.general')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='email') show active @endif" id="email"
                         role="tabpanel" aria-labelledby="pills-add-user-tab">
                        @include('admin.settings.setting.email')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='sms') show active @endif" id="sms" role="tabpanel"
                         aria-labelledby="pills-sms-tab">
                        @include('admin.settings.setting.twillo')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='referral') show active @endif" id="referral"
                         role="tabpanel" aria-labelledby="pills-suspended-user-tab">
                        @include('admin.settings.setting.referral')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='payment') show active @endif" id="payment"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.setting.coinpayment')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='default') show active @endif" id="default"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.setting.default')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='terms') show active @endif" id="terms"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.setting.terms')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='kyc') show active @endif" id="kyc"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.setting.kyc')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='chart') show active @endif" id="chart"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.setting.chart')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='font') show active @endif" id="font"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.setting.font')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->

@endsection

@section('script')
    <script>
        $('.nav-link').on('click', function () {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            var str = '#' + $(this).data('controls');
            $('.tab-pane').removeClass('show active');
            $(str).addClass('show active');
        });
    </script>
@endsection
