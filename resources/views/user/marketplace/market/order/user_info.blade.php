<div class="row mt-5">
    <div class="col-xl-4">
        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title2">{{__('About the ')}}{{$type == 'seller' ? __('Buyer') : __('Seller')}}</h4>
            </div>
        </div>
        <ul class="seller-info">
            <li>
                @if($type == 'seller')
                    <a href="{{route('userTradeProfile',$item->buyer_user_code)}}">{{$item->buyer_username}}</a>
                @else
                    <a href="{{route('userTradeProfile',$item->seller_user_code)}}">{{$item->seller_username}}</a>
                @endif
            </li>
            <li class="text-success">
                <span>{{$feedback.'%'}}</span>
                {{__(' good feedback')}}</li>
            <li>{{__('Registered ')}}
                @if($type == 'seller')
                    {{$item->buyer_registered}}
                @else
                    {{$item->seller_registered}}
                @endif
            </li>
            <li>
                @if($type == 'seller')
                    {{$item->count_buyer_trades}} {{__(' trades')}}
                @else
                    {{$item->count_seller_trades}} {{__(' trades')}}
                @endif
            </li>
        </ul>
    </div>
    <div class="col-xl-8">
        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title2">{{__('Headline ')}}</h4>
                @if(!empty($item->buy_id))
                    <b>{{ $item->buy_data->headline }}</b>
                @elseif(!empty($item->sell_id))
                    <b>{{ $item->sell_data->headline }}</b>
                @else
                    <p>'.....................................'</p>
                @endif
            </div>
        </div>

        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title2">{{__('Terms and Condition ')}}</h4>
                @if(!empty($item->buy_id))
                    <p>{{ $item->buy_data->terms }}</p>
                @elseif(!empty($item->sell_id))
                    <p>{{ $item->sell_data->terms }}</p>
                @else
                    <p>'.....................................'</p>
                @endif
            </div>
        </div>

        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title2">{{__('Trading Instruction')}}</h4>
                @if(!empty($item->buy_id))
                    <p>{{ $item->buy_data->instruction }}</p>
                @elseif(!empty($item->sell_id))
                    <p>{{ $item->sell_data->instruction }}</p>
                @else
                    <p>'.....................................'</p>
                @endif
            </div>
        </div>
    </div>
</div>
