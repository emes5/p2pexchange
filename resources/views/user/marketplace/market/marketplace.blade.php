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
                            <form action="{{route('marketPlace')}}" method="GET" enctype="multipart/form-data" id="">
                                @csrf
                                <div class="row align-items-end">
                                <div class="col-xl-2 col-sm-4 col-lg-4">
                                    <div class="cp-user-payment-type mb-3">
                                        <h3>{{__('Want to')}}</h3>
                                        <select name="offer_type" class=" form-control" >
                                            @foreach(buy_sell() as $key => $value)
                                                <option @if(isset($offer_type) && $offer_type == $key) selected @endif value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-lg-4">
                                    <div class="cp-user-payment-type mb-3">
                                        <h3>{{__('Coin Type')}}</h3>
                                        <select name="coin_type" class=" form-control" >
                                            @if(isset($coins[0]))
                                                @foreach($coins as $coin)
                                                    <option @if(isset($coins_type) && $coins_type == $coin->type) selected @endif value="{{$coin->type}}">{{check_default_coin_type($coin->type)}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-4 col-lg-4">
                                    <div class="cp-user-payment-type mb-3">
                                        <h3>{{__('Location')}}</h3>
                                        <select name="country" class=" form-control" id="country">
                                            <option value="any">{{__('Anywhere')}}</option>
                                            @foreach($countries as $key => $value)
                                                <option @if(isset($country) && $country == $key) selected @endif value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-4 col-lg-4">
                                    <div class="cp-user-payment-type mb-3" id="">
                                        <h3>{{__('Payment Method')}}</h3>
                                        <select name="payment_method" class=" form-control" id="select-payment-method" >
                                            <option value="any">{{__('Any Payment Method')}}</option>
                                            @if(isset($payment_methods[0]))
                                                @foreach($payment_methods as $payment_method)
                                                    @if($country == 'any')
                                                        <option @if(isset($pmethod) && $pmethod == $payment_method->id) selected @endif value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                                                    @elseif(is_accept_payment_method($payment_method->id,$country))
                                                        <option @if(isset($pmethod) && $pmethod == $payment_method->id) selected @endif value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-lg-4">
                                    <div class="cp-user-payment-type text-right mr-3 mb-3">
                                        <h3></h3>
                                        <button type="submit" class="btn theme-btn">{{__('Filter')}}</button>
                                    </div>
                                </div>

                            </div>
                            </form>
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <div class="cp-user-card-header-area">
                                        <div class="title">
                                            <h4 id="list_title">{{__('Buy ')}} {{check_default_coin_type($coins_type)}} {{__(' from these sellers')}}</h4>
                                        </div>
                                    </div>
                                    <div class="cp-user-wallet-table table-responsive buy-table crypto-exchange-table">
                                        <table class="table">
                                            <tbody id="sell-tbody">
                                            @include('user.marketplace.market.include.sells')
                                            </tbody>
                                        </table>
                                        @if(isset($sells[0]))
                                            <div style="display: block; text-align: right">
                                                <input name="sell_offset"  id="sell_offset" type="hidden" value="2">
                                                <input name="sell_total_count"  id="sell_total_count" type="hidden" value="{{$sells_total_count}}">

                                                <a style="color: red; text-decoration: none; text-transform: uppercase; cursor: pointer" id="loadMoreSell">Load More</a>

                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <div class="cp-user-card-header-area">
                                        <div class="title">
                                            <h4 id="list_title">{{__('Sell ')}} {{check_default_coin_type($coins_type)}} {{__(' to these buyers')}}</h4>
                                        </div>
                                    </div>
                                    <div class="cp-user-wallet-table table-responsive buy-table crypto-exchange-table">
                                        <table class="table">
                                            <tbody  id="buy-tbody">
                                            @include('user.marketplace.market.include.buys')
                                            </tbody>
                                        </table>

                                        @if(isset($buys[0]))
                                            <div style="display: block; text-align: right">
                                                <input name="buy_offset"  id="buy_offset" type="hidden" value="2">
                                                <input name="buy_total_count"  id="buy_total_count" type="hidden" value="{{$buys_total_count}}">

                                                <a style="color: red; text-decoration: none; text-transform: uppercase; cursor: pointer" id="loadMoreBuy">Load More</a>

                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- popup --}}
    <div class="modal fade " id="popUpModal" tabindex="-1" aria-hidden="true">
        @include('user.marketplace.market.include.market_popup')
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
                    console.log(data)
                    $('#select-payment-method').html("<option value=\"any\">{{__('Any Payment Method')}}</option>" + data.data)
                    $('#select-payment-method').selectpicker('refresh');
                }
            })
        });

        @if(Auth::user() && Auth::user()->agree_terms == STATUS_DEACTIVE)

        $(window).on('load', function () {
            $('#popUpModal').modal('show');
        });

        @endif




        $(document).ready(function() {
            var sell_increment = 2;
            var sell_offset =   $('#sell_offset').val() ;
            var sell_total_count =  $('#sell_total_count').val() ;
            var next_offset = 0;
            var next_limit = 0;
            var remaining_record = 0;
            var last_offset = 0;
            if(parseInt(sell_total_count) > 0 && parseInt(sell_total_count) > sell_increment )
            {
                $('#loadMoreSell').show();
            }
            else
            {
                $('#loadMoreSell').hide();
            }
        })
            //$('#sell_offset').val("") ;
           //$('#sell_total_count').val("") ;

            $('#loadMoreSell').on('click', function () {
                var sell_increment = 2;
                var sell_offset =   $('#sell_offset').val() ;
                var sell_total_count =  $('#sell_total_count').val() ;
                var next_offset = 0;
                var next_limit = 0;
                var remaining_record = 0;
                var last_offset = 0;
                if(parseInt(sell_total_count) > 0)
                {
                    $('#loadMoreSell').show();
                }
                else
                {
                    $('#loadMoreSell').hide();
                }
                if(parseInt(sell_total_count) > parseInt(sell_offset))
                {
                    remaining_record = parseInt(sell_total_count) - parseInt(sell_offset);
                    //alert(remaining_record);
                    if(remaining_record > sell_increment)
                    {
                        next_offset = sell_offset;
                        next_limit = sell_increment;

                        last_offset = parseInt(next_offset) + parseInt(next_limit);
                        $('#sell_offset').val(last_offset);

                    }
                    else if(remaining_record == sell_increment)
                    {
                        next_offset = sell_offset;
                        next_limit = sell_increment;
                        $('#sell_offset').val(0);
                        $('#loadMoreSell').hide();
                    }
                    else{
                        next_offset = sell_offset;
                        next_limit = remaining_record;
                        $('#sell_offset').val(0);
                        $('#loadMoreSell').hide();
                    }
                }
                else
                {
                    $('#loadMoreSell').hide();
                }

                //return false;

                //var next_offset = parseInt(sell_offset) +  parseInt(1) ;
               // var increment_offset = parseInt(next_offset) +  parseInt(2) ;
               // $('#sell_offset').val(increment_offset);
                $.ajax({
                    type: "POST",
                    url:"{{route('getBuyOfferList')}}",
                    data: JSON.stringify({ '_token': "{{csrf_token()}}",'query_offset': next_offset,'query_limit': next_limit }),
                    contentType: "application/json; charset=utf-8",
                    dataType: "html",
                    success: function(data) {
                        $('#sell-tbody').append(data);
                    },
                    error: function(errMsg) {
                        console.log(errMsg);
                    }
                });


        });

        $('#loadMoreBuy').on('click', function () {
            var buy_increment = 2;
            var buy_offset =   $('#buy_offset').val() ;
            var buy_total_count =  $('#buy_total_count').val() ;
            var next_offset = 0;
            var next_limit = 0;
            var remaining_record = 0;
            var last_offset = 0;
            if(parseInt(buy_total_count) > 0)
            {
                $('#loadMoreBuy').show();
            }
            else
            {
                $('#loadMoreBuy').hide();
            }
            if(parseInt(buy_total_count) > parseInt(buy_offset))
            {
                remaining_record = parseInt(buy_total_count) - parseInt(buy_offset);
                //alert(remaining_record);
                if(remaining_record > buy_increment)
                {
                    next_offset = buy_offset;
                    next_limit = buy_increment;

                    last_offset = parseInt(next_offset) + parseInt(next_limit);
                    $('#buy_offset').val(last_offset);

                }
                else if(remaining_record == buy_increment)
                {
                    next_offset = buy_offset;
                    next_limit = buy_increment;
                    $('#buy_offset').val(0);
                    $('#loadMoreBuy').hide();
                }
                else{
                    next_offset = buy_offset;
                    next_limit = remaining_record;
                    $('#buy_offset').val(0);
                    $('#loadMoreBuy').hide();
                }
            }
            else
            {
                $('#loadMoreBuy').hide();
            }

            //return false;

            //var next_offset = parseInt(sell_offset) +  parseInt(1) ;
            // var increment_offset = parseInt(next_offset) +  parseInt(2) ;
            // $('#sell_offset').val(increment_offset);
            $.ajax({
                type: "POST",
                url:"{{route('getBuyOfferList')}}",
                data: JSON.stringify({ '_token': "{{csrf_token()}}",'query_offset': next_offset,'query_limit': next_limit }),
                contentType: "application/json; charset=utf-8",
                dataType: "html",
                success: function(data) {
                    $('#buy-tbody').append(data);
                },
                error: function(errMsg) {
                    console.log(errMsg);
                }
            });


        })

    </script>
@endsection
