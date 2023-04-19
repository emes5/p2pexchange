<div class="cp-user-card-header-area">
    <div class="title">
        <h4 id="list_title2">{{__('Conversation')}}</h4>
        <h4 id="list_title2">{{__('Messages are end-to-end encrypted.')}}</h4>
    </div>
</div>
<p class="mt-2">
    <span class="">{{__('Say hello and exchange payment details with the other user. ')}}</span>
    <span class="text-warning"><b>{{__(' Remember:')}}</b></span>
    <span>
<ul>
    @if($type == 'seller')
        <li>{{__('Escrow should be released on the spot during the in-person exchange.')}}</li>
    @else
        <li>{{__('Escrow should be released on the spot during the in-person exchange. Don\'t leave until the escrow is released.')}}</li>
    @endif
    <li>{{__('Always use escrow. It\'s there for your safety.')}}</li>
    <li>{{__('Open a payment dispute if you run into trouble.')}}</li>
</ul>
</span>
</p>
<div class="row">
    <div class="col-md-12">
        @include('user.marketplace.market.order.order_chat_data')
    </div>
</div>
