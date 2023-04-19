<div class="row">
    <div class="col-md-6">
        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title2">{{$type == 'seller' ? __('Selling') : __('Buying')}}</h4>
                <h4 id="list_title2">{{number_format(($item->amount),8).' '.check_default_coin_type($item->coin_type) }}</h4>
                <h4 id="list_title2">{{__('for')}}</h4>
                <h4 id="list_title2">{{ $item->currency .' '.number_format($item->price,8) }}</h4>
                <h4 id="list_title2">1 {{ check_default_coin_type($item->coin_type) .' = '.$item->currency .' '.number_format($item->rate,8) }}</h4>
                <h4 id="list_title2"> {{ __('Fees') .' = '.number_format($item->fees,8).' '.check_default_coin_type($item->coin_type) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title2">{{$type == 'seller' ? __('Buyers Feedback ') : __('Sellers Feedback')}}</h4>
                <h4 id="list_title2">
                    @if($type == 'seller')
                        @if(!is_null($item->buyer_feedback))
                            {!! feedback_status($item->buyer_feedback) !!}
                        @endif
                    @else
                        @if(!is_null($item->seller_feedback))
                            {!! feedback_status($item->seller_feedback) !!}
                        @endif
                    @endif
                </h4>
            </div>
        </div>
    </div>
</div>
