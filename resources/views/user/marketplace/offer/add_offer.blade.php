@extends('user.master',[ 'menu'=>'offer'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 mb-xl-0 mb-4">
            <div class="card cp-user-custom-card">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <h4>{{__('Create New Offer')}}</h4>
                    </div>
                    <div class="cp-user-buy-coin-content-area">
                        <div class="cp-user-coin-info">
                            <form action="{{route('offerSaveProcess')}}" method="POST" enctype="multipart/form-data"
                                  id="buy_coin">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-4 mb-xl-0">
                                        <div class="cp-user-payment-type cp-user-payment-type2  mb-3">
                                            <h3>{{__('You want to : ')}}</h3>
                                            <div class="form-groups">
                                                <div class="form-group">
                                                    <input type="radio" value="{{BUY}}" @if(old('offer_type') == BUY) checked @endif id="buy-option" name="offer_type">
                                                    <label for="buy-option">{{__('Buy')}}</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="radio" value="{{SELL}}"  @if(old('offer_type') == SELL) checked @endif id="sell-option" name="offer_type">
                                                    <label for="sell-option">{{__('Sell')}}</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><strong>{{ $errors->first('offer_type') }}</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 mb-xl-0">
                                        <div class="cp-user-payment-type cp-user-payment-type2  mb-3">
                                            <h3>{{__('Select Coin :')}}</h3>
                                            <div class="form-groups">
                                                @if(isset($coins[0]))
                                                    @foreach($coins as $coin)
                                                        <div class="form-group">
                                                            <input type="radio" onclick="call_coin_payment('{{$coin->type}}');" @if(old('coin_type') == $coin->type) checked @endif  value="{{$coin->type}}" id='{{"coin-option".$coin->id}}' name="coin_type">
                                                            <label for='{{"coin-option".$coin->id}}'>{{check_default_coin_type($coin->type)}}</label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>{{__('No coin available right now')}}</p>
                                                @endif
                                            </div>
                                            <span class="text-danger"><strong>{{ $errors->first('coin_type') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 mb-xl-0">
                                        <div class="cp-user-payment-type mb-3">
                                            <h3>{{__('Select country which you want to show')}}</h3>
                                            <select name="country" class=" selectpicker form-control" id="country" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                                                <option value="">{{__('Select country')}}</option>
                                                @foreach($countries as $key => $value)
                                                    <option @if(old('country') == $key) selected @endif value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><strong>{{ $errors->first('country') }}</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 mb-xl-0">
                                        <div class="cp-user-payment-type mb-3">
                                            <h3>{{__('Select payment methods that you want to accept')}}</h3>
                                            <select multiple name="payment_methods[]" class="selectpicker form-control" id="select-payment-method" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                                                @if(isset($payment_methods[0]))
                                                @endif
                                            </select>
                                            <span class="text-danger"><strong>{{ $errors->first('payment_methods') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 mb-xl-0">
                                        <div class="cp-user-payment-type mb-3">
                                            <h3>{{__('Full Address (Optional)')}}</h3>
                                            <input name="address" id="address" class="form-control" placeholder="{{__('Address details')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 mb-xl-0">
                                        <div class="cp-user-payment-type mb-3">
                                            <h3>{{__('Select currency that you want to accept')}}</h3>
                                            <select name="currency" class=" selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                                                <option value="">{{__('Select currency')}}</option>
                                                @if(isset($currencies))
                                                    @foreach($currencies as $key => $value)
                                                        <option @if(old('currency') == $key) selected @endif value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger"><strong>{{ $errors->first('currency') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 mb-xl-0">
                                        <div class="cp-user-payment-type">
                                            <h3>{{__('Select what you like to set your rate')}}</h3>
                                            <small class="text-warning">{{__('Note : For the ').settings('coin_name').__(' coin , only you can select static rate type')}}</small>
                                            <div class="form-group mt-1" id="dynamicRates">
                                                <input type="radio"
                                                       onchange="$('.dynamic_coin_rate').addClass('d-none');$('.static_coin_rate').addClass('d-none');$('.static_coin_rate').removeClass('d-block');$('.dynamic_rate').toggleClass('d-none');"
                                                       value="{{RATE_TYPE_DYNAMIC}}" id="rate_type_dynamic" name="rate_type">
                                                <label for="rate_type_dynamic">{{__('Dynamic Rate')}}</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio"
                                                       onchange="$('.dynamic_coin_rate').addClass('d-none');$('.static_coin_rate').addClass('d-block');$('.static_coin_rate').removeClass('d-none');$('.static_rate').toggleClass('d-none');"
                                                       value="{{RATE_TYPE_STATIC}}" id="rate_type_static" name="rate_type">
                                                <label for="rate_type_static">{{__('Static Rate')}}</label>
                                            </div>
                                            <span class="text-danger"><strong>{{ $errors->first('rate_type') }}</strong></span>
                                        </div>
                                        <div class="cp-user-payment-type dynamic_rate dynamic_coin_rate d-none">
                                            <h3>{{__('Dynamic market price')}}</h3>
                                            <div class="form-group">
                                                <input type="radio" value="{{RATE_ABOVE}}" id="rate_above" name="price_type">
                                                <label for="rate_above">{{__('Above')}}</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" value="{{RATE_BELOW}}" id="rate_below" name="price_type">
                                                <label for="rate_below">{{__('Below')}}</label>
                                            </div>
                                            <span class="text-danger"><strong>{{ $errors->first('price_type') }}</strong></span>
                                            <input name="rate_percentage" value="{{old('rate_percentage')}}" id="" class="form-control" placeholder="{{__('Rate % e.g 1.4 %')}}">
                                            <span class="text-danger"><strong>{{ $errors->first('rate_percentage') }}</strong></span>
                                            <p>{{__('Buyers typically choose a margin of roughly 2% below market price.')}}</p>
                                        </div>

                                        <div class="cp-user-payment-type static_coin_rate static_rate d-none">
                                            <h3>{{__('Static market price')}}</h3>
                                            <input name="coin_rate" value="{{old('coin_rate')}}" id="" class="form-control" placeholder="{{__('')}}">
                                            <span class="text-danger"><strong>{{ $errors->first('coin_rate') }}</strong></span>
                                            <p>{{__('Analysis different kinds of market place and set your price rate. e.g. ')}} 1 <span class="cointype">BTC</span> = ? <span class="currency">USD</span></p>
                                        </div>

                                    </div>
                                    <div class="col-xl-6 mb-xl-0">
                                        <div class="cp-user-payment-type">
                                            <h3>{{__('Set your trade limit size ')}} (in <span class="currency">USD</span>)</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 mb-xl-0">
                                                <div class="cp-user-payment-type">
                                                    <h3>{{__('Minimum trade size')}}</h3>
                                                    <input name="minimum_trade_size" value="{{old('minimum_trade_size')}}" id="" class="form-control" placeholder="{{__('')}}">
                                                    <span class="text-danger"><strong>{{ $errors->first('minimum_trade_size') }}</strong></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 mb-xl-0">
                                                <div class="cp-user-payment-type">
                                                    <h3>{{__('Maximum trade size')}}</h3>
                                                    <input name="maximum_trade_size" value="{{old('maximum_trade_size')}}" id="" class="form-control" placeholder="{{__('')}}">
                                                    <span class="text-danger"><strong>{{ $errors->first('maximum_trade_size') }}</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-xl-12 mb-xl-0">
                                        <div class="cp-user-payment-type mb-3">
                                            <h3>{{__('Offer Headline')}}</h3>
                                            <input name="headline" value="{{old('headline')}}" id="headline" class="form-control" placeholder="{{__('Offer headline')}}">
                                            <span class="text-danger"><strong>{{ $errors->first('headline') }}</strong></span>
                                        </div>
                                        <div class="cp-user-payment-type mb-3">
                                            <h3>{{__('Terms of the trade (Optional)')}}</h3>
                                            <textarea name="terms" class="form-control" id="" cols="30" rows="10">{{old('terms')}}</textarea>
                                        </div>
                                        <div class="cp-user-payment-type mb-3">
                                            <h3>{{__('Trading instructions (Optional)')}}</h3>
                                            <textarea name="instruction" class="form-control" id="" cols="30" rows="10">{{old('instruction')}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button id="buy_button" type="submit" class="btn theme-btn">{{__('Create Offer')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('#country').on('change', function () {
            var country_id = $(this).val();

            $.ajax({
                type: "POST",
                url: "{{route('getCountryPaymentMethod')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'country': country_id
                },
                dataType: 'JSON',

                success: function (data) {
                    $('#select-payment-method').html(data.data);
                    $('#select-payment-method').selectpicker('refresh');
                }
            })
        });

        function call_coin_payment(coin_type)
        {
            if(coin_type == '{{DEFAULT_COIN_TYPE}}') {
                $('#dynamicRates').hide();
            } else {
                $('#dynamicRates').show();
            }
        }
    </script>

@endsection
