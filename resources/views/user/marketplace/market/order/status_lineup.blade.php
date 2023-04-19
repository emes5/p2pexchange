<div class="alert alert-info" role="alert">
    @if($type == 'buyer')
        {{__('Don’t pay the seller until they put ')}} {{check_default_coin_type($item->coin_type)}} {{__(' in escrow. Once escrowed, this status will change.')}}
    @else
        {{__('Before accepting payment, you must put the ')}} {{check_default_coin_type($item->coin_type)}} {{__(' into a secure escrow account.')}}
    @endif
</div>

<div class="row no-gutters">
    @if($item->status == TRADE_STATUS_CANCEL)
        <div class="col-md-12">
            <p id="orderCanceled" class =" text-center font-weight-bold text-danger">
                {{__('Order Cancelled')}}
            </p>
        </div>
    @else
        <div class="col-md-4 col-lg-3">
            <p id="orderPlaced" class="trade-step step-complete">
                @if(!empty($item->buy_id))
                    {{__('Sell order placed')}}
                @elseif(!empty($item->sell_id))
                    {{__('Buy order placed')}}
                @endif
            </p>
        </div>
        <div class="col-md-4 col-lg-3">
            <p id="orderEscrow" class ="trade-step @if($item->status == TRADE_STATUS_ESCROW || $item->status == TRADE_STATUS_PAYMENT_DONE || $item->status == TRADE_STATUS_TRANSFER_DONE) step-complete @endif">
                {{__('Seller puts ')}} {{check_default_coin_type($item->coin_type)}} {{__(' in escrow')}}
            </p>
        </div>
        <div class="col-md-4 col-lg-3">
            <p id="orderPayment" class ="trade-step @if($item->status == TRADE_STATUS_PAYMENT_DONE || $item->status == TRADE_STATUS_TRANSFER_DONE) step-complete @endif">
                {{__('Buyer pays seller directly')}}
            </p>
        </div>
        <div class="col-md-4 col-lg-3">
            <p id="orderComplete" class ="trade-step @if($item->status == TRADE_STATUS_TRANSFER_DONE) step-complete @endif">
                {{__('Escrow released to buyer')}}
            </p>
        </div>
    @endif
</div>
