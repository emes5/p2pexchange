<div class="cp-user-card-header-area">
    <div class="title">
        <h4 id="list_title">{{__('Sell coin to these sellers')}}</h4>
    </div>
</div>
<div class="cp-user-wallet-table table-responsive buy-table">
    <table class="table">
        <thead>
        @if(isset($buys[0]))
            @foreach($buys as $buy)
                <tr>
                    <th>
                        <p class="pb-0 mb-0 border-0"><a href="{{route('userTradeProfile',$buy->user_code)}}">{{$buy->user_name}}</a></p>
                        <p class="pb-0 mb-0 border-0"> {{$buy->user_trades}} {{__(' trades')}}</p>
                    </th>
                    <th>
                        <p class="pb-0 mb-0 border-0">{{__('Coin type')}}</p>
                        <p class="pb-0 mb-0 border-0"> {{$buy->coin_type}} </p>
                    </th>
                    <th>
                        <p class="pb-0 mb-0 border-0">{{__('Payment System')}}</p>
                        <p class="pb-0 mb-0 border-0">
                        @if(isset($buy->payment_method_details[0]))
                            <ul>
                                @foreach($buy->payment_method_details as $buy_payment)
                                    <li>
                                        <span><img width="25"  src="{{$buy_payment['payment_image']}}" alt=""></span>
                                        {{ $buy_payment['payment_name']}}
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                            </p>
                    </th>
                    <th>{{$buy->country}}</th>
                    <th>
                        {{ $buy->size }}
                    </th>
                    <th>
                        <p class="pb-0 mb-0 border-0">{{$buy->rate_details['offer_rate']}}</p>
                        <p class="pb-0 mb-0 border-0">  {{$buy->rate_details['rate_text']}}</p>
                    </th>
                    <th>
                        <a href="{{route('openTrade',['buy',$buy->unique_code])}}"><button class="btn theme-btn">{{__('Sell Now')}}</button></a>
                    </th>
                </tr>
            @endforeach
        @else
            <tr>
                <th colspan="7" class="text-center">{{__('No data available')}}</th>
            </tr>
        @endif
        </thead>
    </table>
    @if(isset($buys[0]))
        <div class="pull-right address-pagin">
            {{ $buys->appends(request()->input())->links() }}
        </div>
    @endif
</div>
