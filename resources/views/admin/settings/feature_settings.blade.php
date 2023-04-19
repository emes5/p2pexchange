@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'feature'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Setting')}}</li>
                    <li class="active-item">{{__('Feature Settings')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management padding-30">
        <form action="{{route('adminFeatureSettingsSave')}}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="header-bar">
                    <div class="table-title">
                        <h3>{{__('Feature enable/disable Settings')}}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-info-form">
                        <div class="row">
                            <div class="col-lg-6 col-12 mt-20">
                                <div class="form-group">
                                    <label>{{__('Buy Coin Feature Enable/Disable')}}</label>
                                    <div class="cp-select-area">
                                        <select name="buy_coin_feature" class="form-control">
                                            <option @if(isset($settings['buy_coin_feature']) && ($settings['buy_coin_feature'] == 2)) selected @endif value="2">{{__('Disable')}}</option>
                                            <option @if(isset($settings['buy_coin_feature']) && ($settings['buy_coin_feature'] == 1)) selected @endif value="1">{{__('Enable')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12  mt-20">
                <div class="header-bar">
                    <div class="table-title">
                        <h3>{{__(' Enable Google Re capcha')}}</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="google_recapcha">{{' Enable Google Re capcha Status'}}</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox"
                               id="google_recapcha" name="google_recapcha"
                               @if(isset($settings['google_recapcha']) &&
                                $settings['google_recapcha'] == STATUS_ACTIVE) checked
                               @endif value="{{STATUS_ACTIVE}}">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12 mt-20">
                        <div class="form-group">
                            <label
                                for="#">{{__('Captcha Secret')}} </label>
                            <input class="form-control " type="text"
                                   name="NOCAPTCHA_SECRET" placeholder=""
                                   value="{{isset($settings['NOCAPTCHA_SECRET']) ? $settings['NOCAPTCHA_SECRET'] : ''}}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 mt-20">
                        <div class="form-group">
                            <label
                                for="#">{{__('Captcha Site key')}} </label>
                            <input class="form-control " type="text"
                                   name="NOCAPTCHA_SITEKEY" placeholder=""
                                   value="{{isset($settings['NOCAPTCHA_SITEKEY']) ? $settings['NOCAPTCHA_SITEKEY'] : ''}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-12 mt-20">
                    <button class="button-primary theme-btn">{{__('Update')}}</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!-- /User Management -->


@endsection

@section('script')
@endsection
