@extends('admin.master',['menu'=>'users','sub_menu'=>'user'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('User management')}}</li>
                    <li class="active-item">{{__('User Profile')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <!-- User Management -->
    <div class="user-management profile">
        <div class="row">
            <div class="col-12">
                <div class="profile-info padding-40">
                    <div class="row">
                        <div class="col-xl-4 mb-xl-0 mb-4">
                            <div class="user-info text-center">
                                <div class="avater-img">
                                    <img src="{{show_image($user->id,'user')}}" alt="">
                                </div>
                                <h4>{{$user->first_name.' '.$user->last_name}}</h4>
                                <p>{{$user->email}}</p>
                            </div>
                            <ul class="profile-transaction">
                                <li class="profile-deposit">
                                    <p>{{__('Total Trades')}}</p>
                                    <h4>{{user_trades_count($user->id,'total')}}</h4>
                                </li>
                                <li class="profile-withdrow">
                                    <p>{{__('Successful Trades')}}</p>
                                    <h4>{{user_trades_count($user->id,TRADE_STATUS_TRANSFER_DONE) }}</h4>
                                </li>
                            </ul>
                            <ul class="profile-transaction">
                                <li class="profile-deposit">
                                    <p>{{__('Cancelled Trades')}}</p>
                                    <h4>{{user_trades_count($user->id,TRADE_STATUS_CANCEL)}}</h4>
                                </li>
                                <li class="profile-withdrow">
                                    <p>{{__('Disputed Trades')}}</p>
                                    <h4>{{ user_disputed_trades($user->id) }}</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-8">
                            <div class="profile-info-table">
                                <ul>
                                    <li>
                                        <span>{{__('Coin ')}}</span>
                                        <span class="dot">:</span>
                                        <span><strong>{{__('Balance')}}</strong></span>
                                    </li>
                                    @if(isset($coins[0]))
                                        @foreach($coins as $coin)
                                            <li>
                                                <span>{{ check_default_coin_type($coin->type) }}</span>
                                                <span class="dot">:</span>
                                                <span><strong>{{ user_coin_balance($user->id,$coin->type) }}</strong></span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="header-bar p-4">
                                <div class="table-title">
                                    <h3>{{__('User Sell Offer')}}</h3>
                                </div>
                            </div>
                            <div class="cp-user-wallet-table table-responsive buy-table">
                                <table class="table">
                                    <tbody>
                                    @if(isset($sells[0]))
                                        @foreach($sells as $sell)
                                            <tr>
                                                <td>
                                                    <p class="pb-0 mb-0 border-0">{{$sell->user->first_name.' '.$sell->user->last_name}}</p>
                                                    <p class="pb-0 mb-0 border-0"> {{count_trades($sell->user->id)}} {{__(' trades')}}</p>
                                                </td>
                                                <td>
                                                    <p class="pb-0 mb-0 border-0">{{__('Coin type')}}</p>
                                                    <p class="pb-0 mb-0 border-0"> {{check_default_coin_type($sell->coin_type)}} </p>
                                                </td>
                                                <td>
                                                    <p class="pb-0 mb-0 border-0">{{__('Payment System')}}</p>
                                                    <p class="pb-0 mb-0 border-0">
                                                    @if(isset($sell->payment($sell->id)[0]))
                                                        <ul>
                                                            @foreach($sell->payment($sell->id) as $sell_payment)
                                                                <li>
                                                                    <span><img width="25" src="{{$sell_payment->payment_method->image}}" alt=""></span>
                                                                    {{ $sell_payment->payment_method->name}}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    </p>
                                                </td>
                                                <td>{{countrylist($sell->country)}}</td>
                                                <td>
                                                    {{number_format($sell->minimum_trade_size,2). ' '.$sell->currency }} {{__(' to ')}} {{number_format($sell->maximum_trade_size,2). ' '.$sell->currency }}
                                                </td>
                                                <td>
                                                    @if($sell->rate_type == RATE_TYPE_DYNAMIC)
                                                        <p class="pb-0 mb-0 border-0">{{number_format($sell->coin_rate,2).' '.$sell->currency}}</p>
                                                        <p class="pb-0 mb-0 border-0"> {{number_format($sell->rate_percentage,2)}} % {{price_rate_type($sell->price_type)}} {{__(' Market')}}</p>

                                                    @else
                                                        <p class="pb-0 mb-0 border-0">{{number_format($sell->coin_rate,2).' '.$sell->currency}}</p>
                                                        <p class="pb-0 mb-0 border-0">  {{__(' Static Rate')}}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul class="d-flex activity-menu">
                                                        <li class="viewuser">
                                                            <a title="{{__('Details')}}" href="{{route('offerDetails', [encrypt($sell->id),SELL])}}">
                                                                <img src="{{asset("assets/admin/images/user-management-icons/activity/view.svg")}}" class="img-fluid" alt="">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">{{__('No data available')}}</th>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(isset($sells[0]))
                                    <div class="pull-right address-pagin">
                                        {{ $sells->appends(request()->input())->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="header-bar p-4">
                                <div class="table-title">
                                    <h3>{{__('User Buy Offer')}}</h3>
                                </div>
                            </div>
                            <div class="cp-user-wallet-table table-responsive buy-table">
                                <table class="table">
                                    <tbody>
                                    @if(isset($buys[0]))
                                        @foreach($buys as $buy)
                                            <tr>
                                                <td>
                                                    <p class="pb-0 mb-0 border-0">{{$buy->user->first_name.' '.$buy->user->last_name}}</p>
                                                    <p class="pb-0 mb-0 border-0"> {{count_trades($buy->user->id)}} {{__(' trades')}}</p>
                                                </td>
                                                <td>
                                                    <p class="pb-0 mb-0 border-0">{{__('Coin type')}}</p>
                                                    <p class="pb-0 mb-0 border-0"> {{check_default_coin_type($buy->coin_type)}} </p>
                                                </td>
                                                <td>
                                                    <p class="pb-0 mb-0 border-0">{{__('Payment System')}}</p>
                                                    <p class="pb-0 mb-0 border-0">
                                                    @if(isset($buy->payment($buy->id)[0]))
                                                        <ul>
                                                            @foreach($buy->payment($buy->id) as $buy_payment)
                                                                <li>
                                                                    <span><img width="25" src="{{$buy_payment->payment_method->image}}" alt=""></span>
                                                                    {{ $buy_payment->payment_method->name}}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    </p>
                                                </td>
                                                <td>{{countrylist($buy->country)}}</td>
                                                <td>
                                                    {{number_format($buy->minimum_trade_size,2). ' '.$buy->currency }} {{__(' to ')}} {{number_format($buy->maximum_trade_size,2). ' '.$buy->currency }}
                                                </td>
                                                <td>
                                                    @if($buy->rate_type == RATE_TYPE_DYNAMIC)
                                                        <p class="pb-0 mb-0 border-0">{{number_format($buy->coin_rate,2).' '.$buy->currency}}</p>
                                                        <p class="pb-0 mb-0 border-0"> {{number_format($buy->rate_percentage,2)}} % {{price_rate_type($buy->price_type)}} {{__(' Market')}}</p>

                                                    @else
                                                        <p class="pb-0 mb-0 border-0">{{number_format($buy->coin_rate,2).' '.$buy->currency}}</p>
                                                        <p class="pb-0 mb-0 border-0">  {{__(' Static Rate')}}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul class="d-flex activity-menu">
                                                        <li class="viewuser">
                                                            <a title="{{__('Details')}}" href="{{route('offerDetails', [encrypt($buy->id),BUY])}}">
                                                                <img src="{{asset("assets/admin/images/user-management-icons/activity/view.svg")}}" class="img-fluid" alt="">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th colspan="7" class="text-center">{{__('No data available')}}</th>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(isset($buys[0]))
                                    <div class="pull-right address-pagin">
                                        {{ $buys->appends(request()->input())->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="header-bar p-4">
                                <div class="table-title">
                                    <h3>{{__('User Trade List')}}</h3>
                                </div>
                            </div>
                            <div class="table-area">
                                <div>
                                    <table id="table" class="table-responsive table table-borderless custom-table display text-center" width="100%">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('Buyer')}}</th>
                                            <th scope="col">{{__('Seller')}}</th>
                                            <th scope="col">{{__('Coin Type')}}</th>
                                            <th scope="col">{{__('Coin Rate')}}</th>
                                            <th scope="col">{{__('Amount')}}</th>
                                            <th scope="col">{{__('Price')}}</th>
                                            <th scope="col">{{__('Created At')}}</th>
                                            <th scope="col">{{__('Status')}}</th>
                                            <th scope="col">{{__('Activity')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->
@endsection

@section('script')
    <script>
        (function($) {
            "use strict";

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                retrieve: true,
                bLengthChange: true,
                responsive: false,
                ajax: '{{route('userTradingProfile',encrypt($user->id))}}',
                order: [6, 'desc'],
                autoWidth: false,
                language: {
                    paginate: {
                        next: 'Next &#8250;',
                        previous: '&#8249; Previous'
                    }
                },
                columns: [
                    {"data": "buyer_id", "orderable": false},
                    {"data": "seller_id", "orderable": false},
                    {"data": "coin_type", "orderable": false},
                    {"data": "rate", "orderable": false},
                    {"data": "amount", "orderable": false},
                    {"data": "price", "orderable": false},
                    {"data": "created_at", "orderable": false},
                    {"data": "status", "orderable": false},
                    {"data": "activity", "orderable": false}
                ],
            });
        })(jQuery);
    </script>
@endsection
