@extends('user.master',['menu'=>'profile'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="tab-content cp-user-profile-tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active in " id="pills-profile"
                     role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="cp-user-card-header-area">
                        <div class="title">
                            <h4 id="list_title">{{$user->username}}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-xl-0 mb-4">
                            <div class="card cp-user-custom-card">
                                <div class="card-body">
                                    <div class="user-profile-area">
                                        <div class="user-profile-img">
                                            <img src="{{show_image($user->id,'user')}}" class="img-fluid" alt="">
                                        </div>
                                        <div class="user-cp-user-profile-info">
                                            <h4>{{$user->username}}</h4>
                                            <p class="cp-user-btc">
                                                <span @if($user->online_status == 'online') class="text-success" @else class="text-secondary" @endif>
                                                    <b>{{$user->online_status}}</b>
                                                </span>
                                            </p>
                                            <p class="cp-user-btc">
                                                <span class="text-secondary"><b>{{__('Last seen: ').$user->last_seen}}</b></span>
                                            </p>
                                            <div class="cp-user-available-balance-profile">
                                                <p>{{$user_trading_info['total_trades']}} {{__(' total trades')}}</p>
                                                <p>{{$user_trading_info['successful_trades']}} {{__(' successful trades')}}</p>
                                                <p>{{$user_trading_info['ongoing_trades']}} {{__(' ongoing trades')}}</p>
                                                <p>{{$user_trading_info['cancelled_trades']}} {{__(' cancelled trades')}}</p>
                                                <p>{{$user_trading_info['disputed_trades']}} {{__(' disputed trades')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="card cp-user-custom-card">
                                <div class="card-body">
                                    <div class="cp-user-profile-header">
                                        <h5>{{__('Profile Information')}}</h5>
                                    </div>
                                    <div class="cp-user-profile-info">
                                        <ul>
                                            <li>
                                                <span>{{__('Username')}}</span>
                                                <span class="cp-user-dot">:</span>
                                                <span>{{$user->username}}</span>
                                            </li>
                                            <li>
                                                <span>{{__('Country')}}</span>
                                                <span class="cp-user-dot">:</span>
                                                <span>
                                                    @if(!empty($user->country))
                                                        {{countrylist(strtoupper($user->country))}}
                                                    @endif
                                                </span>
                                            </li>
                                            <li>
                                                <span>{{__('Email Verification')}}</span>
                                                <span class="cp-user-dot">:</span>
                                                <span>{{statusAction($user->is_verified)}}</span>
                                            </li>
                                            <li>
                                                <span>{{__('Phone Verification')}}</span>
                                                <span class="cp-user-dot">:</span>
                                                <span class="pending">{{statusAction($user->phone_verified)}}</span>
                                            </li>
                                            <li>
                                                <span>{{__('Active Status')}}</span>
                                                <span class="cp-user-dot">:</span>
                                                <span>{{statusAction($user->status)}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            @include('user.marketplace.user.include.buy')
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            @include('user.marketplace.user.include.sell')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
