<div class="cp-user-card-header-area">
    <div class="title">
        <h4 id="list_title">{{__('Buy coin from these sellers')}}</h4>
    </div>
</div>
<div class="cp-user-wallet-table table-responsive buy-table">
    <table class="table">
        <thead>
        @if(isset($sells[0]))
            @foreach($sells as $sell)
                <tr>
                    <th>
                        <p class="pb-0 mb-0 border-0"><a href="{{route('userTradeProfile',$sell->user_code)}}">{{$sell->user_name}}</a></p>
                        <p class="pb-0 mb-0 border-0"> {{$sell->user_trades}} {{__(' trades')}}</p>
                    </th>
                    <th>
                        <p class="pb-0 mb-0 border-0">{{__('Coin type')}}</p>
                        <p class="pb-0 mb-0 border-0"> {{$sell->coin_type}} </p>
                    </th>
                    <th>
                        <p class="pb-0 mb-0 border-0">{{__('Payment System')}}</p>
                        <p class="pb-0 mb-0 border-0">
                        @if(isset($sell->payment_method_details[0]))
                            <ul>
                                @foreach($sell->payment_method_details as $sell_payment)
                                    <li>
                                        <span><img width="25"  src="{{$sell_payment['payment_image']}}" alt=""></span>
                                        {{ $sell_payment['payment_name']}}
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                            </p>
                    </th>
                    <th>{{$sell->country}}</th>
                    <th>
                        {{ $sell->size }}
                    </th>
                    <th>
                        <p class="pb-0 mb-0 border-0">{{$sell->rate_details['offer_rate']}}</p>
                        <p class="pb-0 mb-0 border-0">  {{$sell->rate_details['rate_text']}}</p>
                    </th>
                    <th>
                        <a href="{{route('openTrade',['buy',$sell->unique_code])}}"><button class="btn theme-btn">{{__('Buy Now')}}</button></a>
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
    @if(isset($sells[0]))
        <div class="pull-right address-pagin">
            {{ $sells->appends(request()->input())->links() }}
        </div>
    @endif
</div>
