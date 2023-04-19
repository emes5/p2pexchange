@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'landing'])
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
                        <a class="@if(isset($tab) && $tab=='home') active @endif nav-link " id="pills-user-tab"
                           data-toggle="pill" data-controls="general" href="#general" role="tab"
                           aria-controls="pills-user" aria-selected="true">
                            <span>{{__('Home Settings')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='about') active @endif nav-link " id="pills-add-user-tab"
                           data-toggle="pill" data-controls="email" href="#email" role="tab"
                           aria-controls="pills-add-user" aria-selected="true">
                            <span>{{__('About Settings')}} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='feature') active @endif nav-link " id="pills-sms-tab"
                           data-toggle="pill" data-controls="sms" href="#sms" role="tab" aria-controls="pills-sms"
                           aria-selected="true">
                            <span>{{__('Feature Settings')}} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='trade') active @endif nav-link "
                           id="pills-deleted-user-tab" data-toggle="pill" data-controls="withdraw" href="#withdraw"
                           role="tab" aria-controls="pills-deleted-user" aria-selected="true">
                            <span>{{__('How To Trade')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='testimonial') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="payment" href="#payment" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('Testimonial Setting')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='faq') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="faq" href="#faq" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('Faq Setting')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='newsletter') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="newsletter" href="#newsletter" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                            <span>{{__('Newsletter Setting')}}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show @if(isset($tab) && $tab=='home')  active @endif" id="general"
                         role="tabpanel" aria-labelledby="pills-user-tab">
                        @include('admin.settings.landing.home')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='about') show active @endif" id="email"
                         role="tabpanel" aria-labelledby="pills-add-user-tab">
                        @include('admin.settings.landing.about')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='feature') show active @endif" id="sms" role="tabpanel"
                         aria-labelledby="pills-sms-tab">
                        @include('admin.settings.landing.feature')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='trade') show active @endif" id="withdraw"
                         role="tabpanel" aria-labelledby="pills-deleted-user-tab">
                        @include('admin.settings.landing.trade')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='testimonial') show active @endif" id="payment"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.landing.testimonial')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='faq') show active @endif" id="faq"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.landing.faq')
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='newsletter') show active @endif" id="newsletter"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        @include('admin.settings.landing.newesletter')
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


        // add key_feature_wrapper
        const featureWrapper = $('#key_feature_wrapper');


        $(document).on('click', '.addKeyFeatureBtn', function () {
            featureWrapper.append("<div class=\"row dynamicClass\">\n" +
                "                                            <div class=\"col-md-4\">\n" +
                "                                                <div class=\"form-group\">\n" +
                "                                                    <input type=\"text\" name=\"pexer_feature[]\"  value=\"\"\n" +
                "                                                           class=\"form-control\" placeholder=\"Feature Title\">\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "                                            <div class=\"col-md-4\">\n" +
                "                                                <div class=\"form-group\">\n" +
                "                                                    <textarea name=\"pexer_value[]\" placeholder=\"Feature Description\" id=\"\" rows=\"2\" class=\"form-control\"></textarea>\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "<div class=\"col-md-3 text-right\">\n" +
                "                                                <div class=\"d-flex\">\n" +
                "                                                    <p class=\"btn btn-primary addKeyFeatureBtn px-5 mb-3 mr-3\">{{__('Add More')}}</p>\n" +
                "                                                    <p class=\"btn btn-danger  removeKeyFeatureBtn px-5 mb-3\">{{__('Remove')}}</p>\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "                                        </div>");
        });

        $(document).on('click', '.removeKeyFeatureBtn', function () {
            $(this).parent().closest('.dynamicClass').remove();
        });

        function delete_feature(feature_id) {
            $.ajax({
                type: "POST",
                url: "{{route('pexerFeatureDelete')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'feature_id': feature_id
                },
                dataType: 'JSON',
                success: function (data) {
                    $('#key_feature_prxer' + feature_id).remove()
                },
                error: function () {

                }
            });
        }
    </script>
@endsection
