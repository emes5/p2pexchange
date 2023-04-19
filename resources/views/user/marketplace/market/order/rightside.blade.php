<div class="row align-items-end">
    <div class="col-md-6">
        <div class="cp-user-card-header-area">
            <div class="title">
                <h4 id="list_title2">{{__('You are the ')}}{{$type == 'buyer' ? __('Buyer') : __('Seller')}}</h4>
                <h4 id="list_title2">{{__('Order id :  ')}} {{ $item->order_id}}</h4>
                @if($item->status == TRADE_STATUS_TRANSFER_DONE)
                    <h4 id="list_title2">{{__('Transaction id :  ')}} {{ $item->transaction_id}}</h4>
                @endif
                <h4 id="list_title2">{{__('Selected payment method is :  ')}}
                    <span><img src="{{$item->payment_method_image}}" alt=""></span>
                    {{ $item->payment_method_name}}
                </h4>
                @if($item->status != TRADE_STATUS_TRANSFER_DONE)
                    <h4 id="list_title2">{{__('Waiting for the ')}}{{$type == 'seller' ? __('Buyer') : __('Seller')}}</h4>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        @if(!empty($item->payment_sleep))
            <div class="view-payment-receipt">
                <Button class="btn theme-btn" data-target="#view-payment-receipt" data-toggle="modal">{{__('View Payment Receipt')}}</Button>
            </div>
            <div id="view-payment-receipt" class="modal fade view-payment-receipt-modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><h6 class="modal-title">{{__('Payment Receipt')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>

                        <div class="modal-body">
                            @if(!empty($item->payment_sleep))
                                <img src="{{$item->payment_sleep_path}}" alt="">
                            @else
                                <p>{{__('Payment slip not found')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@include('user.marketplace.market.order.status_lineup')
@include('user.marketplace.market.order.status_action')
@include('user.marketplace.market.order.user_info')


