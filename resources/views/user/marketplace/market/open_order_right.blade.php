<div class="cp-user-card-header-area">
    <div class="title">
        <h4 id="list_title">{{__('You are the ')}}{{$type == 'buy' ? __('Buyer') : __('Seller')}}</h4>
    </div>
</div>
<div class="cp-user-payment-type available-payment-method-list">
    <h3>{{__('Available Payment Method')}} </h3>
    @if(isset($offer->payment_method_details[0]))
        @foreach($offer->payment_method_details as $pmethod)
            <ul>
                <li class="text-warning">
                    <span><img width="25" src="{{$pmethod['payment_image']}}" alt=""></span>
                    {{ $pmethod['payment_name']}}
                </li>
            </ul>
        @endforeach
    @endif

    <h3 class="mt-5 ">
                                                   <span class="text-center">
                                                       1 {{$offer->coin_type}} = {{number_format($offer->coin_rate,2)}}{{' '.$offer->currency}}
                                                   </span>
    </h3>
    <p class="mt-1 ">
        {{__('The ')}} {{$type == 'buy' ? __('Buyer') : __('Seller')}} {{__(' chose this price — only continue if you’re comfortable with it.')}}
    </p>
</div>
<div class="row">
    <div class="col-xl-4">
        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title">{{__('About the ')}}{{$type == 'sell' ? __('Buyer') : __('Seller')}}</h4>
            </div>
        </div>
        <ul class="about-seller">
            <li>
                <a href="{{route('userTradeProfile',$offer->user_code)}}">{{$offer->user_name}}</a>
            </li>
            <li>
                <span>{{$offer->user_trade_feedback.'%'}}</span>
                {{__(' good feedback')}}
            </li>
            <li>{{__('Registered ')}} {{$offer->user_registered}}</li>
            <li>{{$offer->user_trades}} {{__(' trades')}} </li>
        </ul>
    </div>
    <div class="col-xl-8">
        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title">{{__('Headline ')}}</h4>
            </div>
        </div>
        <p>{{ $offer->headline }}</p>

        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title">{{__('Terms and Condition ')}}</h4>
            </div>
        </div>
        <p>{{ isset($offer->terms) ? $offer->terms : '.....................................'}}</p>

        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title">{{__('Trading Instruction')}}</h4>
            </div>
        </div>
        <p>{{ isset($offer->instruction) ? $offer->instruction : '.....................................'}}</p>
    </div>
</div>
