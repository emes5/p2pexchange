<tr>
    <td>
        <h4><a href="{{route('userTradeProfile',$sell->user->unique_code)}}">{{$sell->user->username}}</a></h4>
        <p> {{count_trades($sell->user->id)}} {{__(' trades')}}</p>
    </td>
    <td>
        <h4>{{__('Payment System')}}</h4>
        @if(isset($sell->payment($sell->id)[0]))
            <ul>
                @foreach($sell->payment($sell->id) as $sell_payment)
                    @if($country == 'any')
                        <li>
                            <span><img width="25" src="{{$sell_payment->payment_method->image}}" alt=""></span>
                            {{ $sell_payment->payment_method->name}}
                        </li>
                    @elseif(is_accept_payment_method($sell_payment->payment_method_id,$country))
                        <li>
                            <span><img width="25" src="{{$sell_payment->payment_method->image}}" alt=""></span>
                            {{ $sell_payment->payment_method->name}}
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </td>
    <td>
        <h4>{{countrylist($sell->country)}}</h4>
        <p>{{$sell->address}}</p>

    </td>
    <td>
        <h4>{{number_format($sell->minimum_trade_size,2). ' '.$sell->currency }} {{__(' to ')}} {{number_format($sell->maximum_trade_size,2). ' '.$sell->currency }}</h4>
    </td>
    <td>
        @if($sell->rate_type == RATE_TYPE_DYNAMIC)
            <p class="normal">{{number_format($sell->coin_rate,2).' '.$sell->currency}}</p>
            <p class="mute"> {{number_format($sell->rate_percentage,2)}} % {{price_rate_type($sell->price_type)}} {{__(' Market')}}</p>

        @else
            <p class="normal">{{number_format($sell->coin_rate,2).' '.$sell->currency}}</p>
            <p class="mute">  {{__(' Static Rate')}}</p>
        @endif
    </td>
    <td class="text-right">
        <a href="{{route('openTrade',['buy',$sell->unique_code])}}"><button class="btn theme-btn">{{__('Buy Now')}}</button></a>
    </td>
</tr>
