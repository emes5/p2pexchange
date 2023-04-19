@extends('user.master',[ 'menu'=>'marketplace'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 mb-xl-0 mb-4">
            <div class="card cp-user-custom-card">
                <div class="card-body">
                    <div class="cp-user-buy-coin-content-area">
                        <div class="cp-user-coin-info">
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <div class="cp-user-card-header-area">
                                        <div class="title">
                                            <h4 id="list_title"><a href="{{route('marketPlace')}}">{{__(' Offer ')}}</a> -> {{$type_text}}  <a href="{{route('userTradeProfile',$offer->user_code)}}">{{$offer->user_name}}</a></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <form action="{{route('placeOrder')}}" method="POST" enctype="multipart/form-data"
                                                  id="buy_coin">
                                                @csrf
                                            <div class="cp-user-card-header-area">
                                                <div class="title">
                                                    <h4 id="list_title">{{__('Open Trade')}}</h4>
                                                </div>
                                            </div>
                                            <div class="cp-user-payment-type">
                                                <input type="hidden" name="type" value="{{$type}}">
                                                <input type="hidden" name="offer_id" value="{{$offer->id}}">
                                                <h3>{{__('Trade Amount ')}} <span>{{ $offer->size  }}</span></h3>
                                                <div class="input-group mb-3 w-85 ">
                                                    <input name="price" id="tradeprice" class="form-control">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text px-4"><span class="currency text-warning">{{$offer->currency}}</span></span>
                                                    </div>
                                                </div>
                                                <br/>
                                                <span class="text-danger"><strong>{{ $errors->first('price') }}</strong></span>

                                                <div class="input-group mb-3 w-85 ">
                                                    <input name="amount" id="tradeamount" class="form-control" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text px-4"><span class="currency text-warning">{{$offer->coin_type}}</span></span>
                                                    </div>
                                                </div>
                                                <span class="text-danger"><strong>{{ $errors->first('amount') }}</strong></span>
                                            </div>
                                            <div class="cp-user-payment-type">
                                                <h3>{{__('Select Payment Method')}}</h3>
                                                @if(isset($offer->payment_method_details[0]))
                                                    @foreach($offer->payment_method_details as $pmethod)
                                                        <div class="form-group">
                                                            <input type="radio"  @if(old('payment_id') == $pmethod['payment_id']) checked @endif  value="{{$pmethod['payment_id']}}" id='{{"coin-option".$pmethod['payment_id']}}' name="payment_id">
                                                            <label for='{{"coin-option".$pmethod['payment_id']}}'>{{$pmethod['payment_name']}}</label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <span class="text-danger"><strong>{{ $errors->first('payment_id') }}</strong></span>
                                            </div>
                                            <div class="cp-user-payment-type">
                                                <h3>{{__('Send Message ')}} </h3>
                                                <textarea name="text_message" class="form-control" id="" cols="30" rows="10" placeholder="{{__('Say hello,. Traders use encrypted messages to exchange payment details.')}}">{{old('text_message')}}</textarea>
                                            </div>
                                                <button id="buy_button" type="submit" class="mt-4 btn theme-btn">{{__('Open Trade')}}</button>
                                            <p class="mt-2">
                                                <span class="text-warning"><b>{{__('Note : ')}}</b></span>
                                                <span class="">{{__('Once you open a trade, messages are end-to-end encrypted so your privacy is protected. The only case where we can read your messages is if either party initiates a dispute. ')}}</span>
                                            </p>

                                            </form>
                                        </div>
                                        <div class="col-xl-1"></div>
                                        <div class="col-xl-7">
                                            @include('user.marketplace.market.open_order_right')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function delay(callback, ms) {
            var timer = 0;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        function call_trade_coin_rate(amount, type, order_type, offer_id) {

            $.ajax({
                type: "POST",
                url: "{{ route('getTradeCoinRate') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'amount': amount,
                    'type': type,
                    'order_type': order_type,
                    'offer_id': offer_id,
                },
                dataType: 'JSON',

                success: function (data) {
                    $('#tradeamount').val(data.amount)
                    $('#tradeprice').val(data.price)
                },
                error: function () {

                }
            });
        }

        $("#tradeamount").on('keyup', delay(function (e) {
            var amount = $('input[name=amount]').val();
            var type = 'same';
            var order_type = '{{$type}}';
            var offer_id = '{{$offer->id}}';

            call_trade_coin_rate(amount, type, order_type, offer_id);

        }, 500));

        $("#tradeprice").on('keyup', delay(function (e) {
            var amount = $('input[name=price]').val();
            var type = 'reverse';
            var order_type = '{{$type}}';
            var offer_id = '{{$offer->id}}';

            call_trade_coin_rate(amount, type, order_type, offer_id);

        }, 500));
    </script>
@endsection
