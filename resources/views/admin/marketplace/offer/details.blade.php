@extends('admin.master',['menu'=>'offer', 'sub_menu'=>$sub_menu])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-9">
                <ul>
                    <li>{{__('Crypto Exchange')}}</li>
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
                <div class="header-bar p-4">
                    <div class="table-title">
                        <h3>{{ $title }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="profile-info-table">
                    <ul>
                        <li>
                            <span>{{__('User Name')}}</span>
                            <span class="dot">:</span>
                            <span><strong>{{$item->user->first_name.' '.$item->user->last_name}}</strong></span>
                        </li>
                        <li>
                            <span>{{__('Crypto Coin Type')}}</span>
                            <span class="dot">:</span>
                            <span><strong>{{check_default_coin_type($item->coin_type)}}</strong></span>
                        </li>
                        <li>
                            <span>{{__('Country')}}</span>
                            <span class="dot">:</span>
                            <span><strong>{{countrylist($item->country)}}</strong></span>
                        </li>
                        <li>
                            <span>{{__('User Address')}}</span>
                            <span class="dot">:</span>
                            <span class=""><strong>{{$item->address}}</strong></span>
                        </li>
                        <li>
                            <span>{{__('Active Status')}}</span>
                            <span class="dot">:</span>
                            <span>{{offer_active_status($item->status)}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="profile-info-table">
                    <ul>
                        <li>
                            <span>{{__('Trade size')}}</span>
                            <span class="dot">:</span>
                            <span>
                                <strong>{{number_format($item->minimum_trade_size,2). ' '.$item->currency }} {{__(' to ')}} {{number_format($item->maximum_trade_size,2). ' '.$item->currency }}</strong>
                            </span>
                        </li>
                        <li>
                            <span>{{__('Coin Rate Type')}}</span>
                            <span class="dot">:</span>
                            <span><strong>{{coin_rate_type($item->rate_type)}}</strong></span>
                        </li>
                        <li>
                            <span>{{__('Coin Rate ')}}</span>
                            <span class="dot">:</span>
                            <span>
                                <strong>
                                    @if($item->rate_type == RATE_TYPE_DYNAMIC)
                                        <p class="pb-0 mb-0 border-0">{{number_format($item->coin_rate,2).' '.$item->currency}}</p>
                                        <p class="pb-0 mb-0 border-0"> {{number_format($item->rate_percentage,2)}} % {{price_rate_type($item->price_type)}} {{__(' Market')}}</p>

                                    @else
                                        <p class="pb-0 mb-0 border-0">{{number_format($item->coin_rate,2).' '.$item->currency}}</p>
                                        <p class="pb-0 mb-0 border-0">  {{__(' Static Rate')}}</p>
                                    @endif
                                </strong>
                            </span>
                        </li>
                        <li>
                            <span>{{__('Headline')}}</span>
                            <span class="dot">:</span>
                            <span>{{$item->headline}}</span>
                        </li>
                        <li>
                            <span>{{__('Payment method')}}</span>
                            <span class="dot">:</span>
                            <span>
                                @if(isset($item->payment($item->id)[0]))
                                    @foreach($item->payment($item->id) as $item_payment)
                                        <img width="25" src="{{$item_payment->payment_method->image}}" alt="">
                                        {{ $item_payment->payment_method->name}}
                                    @endforeach
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="term-condition">
                            <li>
                                <strong>{{__('Terms and conditions')}}</strong>
                                <span class="dot">:</span>
                                <p>{{$item->terms}}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="term-condition">
                            <li>
                                <strong>{{__('Instruction')}}</strong>
                                <span class="dot">:</span>
                                <p>{{$item->instruction}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->

@endsection
@section('script')
@endsection
