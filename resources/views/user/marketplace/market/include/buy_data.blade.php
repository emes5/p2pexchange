<tr>
    <td>
        <h4><a href="{{route('userTradeProfile',$buy->user->unique_code)}}">{{$buy->user->username}}</a></h4>
        <p> {{count_trades($buy->user->id)}} {{__(' trades')}}</p>
    </td>
    <td>
        <h4>{{__('Payment System')}}</h4>
        @if(isset($buy->payment($buy->id)[0]))
            <ul class="payment-system-list">
                @foreach($buy->payment($buy->id) as $buy_payment)
                    @if($country == 'any')
                        <li>
                            <span><img width="25" src="{{$buy_payment->payment_method->image}}" alt=""></span>{{ $buy_payment->payment_method->name}}
                        </li>
                    @elseif(is_accept_payment_method($buy_payment->payment_method_id,$country))
                        <li>
                            <span><img width="25" src="{{$buy_payment->payment_method->image}}" alt=""></span>{{ $buy_payment->payment_method->name}}
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </td>
    <td><h4>{{countrylist($buy->country)}}</h4></td>
    <td>
        {{number_format($buy->minimum_trade_size,2). ' '.$buy->currency }} {{__(' to ')}} {{number_format($buy->maximum_trade_size,2). ' '.$buy->currency }}
    </td>
    <td>
        @if($buy->rate_type == RATE_TYPE_DYNAMIC)
            <p class="normal">{{number_format($buy->coin_rate,2).' '.$buy->currency}}</p>
            <p class="mute"> {{number_format($buy->rate_percentage,2)}} % {{price_rate_type($buy->price_type)}} {{__(' Market')}}</p>

        @else
            <p class="normal">{{number_format($buy->coin_rate,2).' '.$buy->currency}}</p>
            <p class="mute">  {{__(' Static Rate')}}</p>
        @endif
    </td>
    <td class="text-right">
        <a href="{{route('openTrade',['sell',$buy->unique_code])}}"><button class="btn theme-btn">{{__('Sell Now')}}</button></a>
    </td>
</tr>
