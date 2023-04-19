@extends('user.master',[ 'menu'=>'trade'])
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
                                            <h4 id="list_title">{{__('My Trade List')}}</h4>
                                        </div>
                                    </div>
                                    <div class="cp-user-wallet-table table-responsive buy-table">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{__('Date Opened')}}</th>
                                                <th>{{__('Type')}}</th>
                                                <th>{{__('Crypto')}}</th>
                                                <th>{{__('Fees')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                <th>{{__('Trade partner')}}</th>
                                                <th>{{__('State')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($items[0]))
                                                @foreach($items as $item)
                                                    <tr>
                                                        <td>{{ date('d M y', strtotime($item->created_at)) }}</td>
                                                        <td>
                                                            @if($item->buyer_id == Auth::id())
                                                                {{__('Buying')}}
                                                            @elseif($item->seller_id == Auth::id())
                                                                {{__('Selling')}}
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->amount.' '.check_default_coin_type($item->coin_type) }}</td>
                                                        <td>{{ $item->fees.' '.check_default_coin_type($item->coin_type) }}</td>
                                                        <td>{{ $item->price.' '.$item->currency }}</td>
                                                        <td>
                                                            @if($item->buyer_id == Auth::id())
                                                                <a href="{{route('userTradeProfile',$item->seller_id)}}"> {{$item->seller->first_name.' '.$item->seller->last_name}} </a>
                                                            @elseif($item->seller_id == Auth::id())
                                                                <a href="{{route('userTradeProfile',$item->buyer_id)}}"> {{$item->buyer->first_name.' '.$item->buyer->last_name}} </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ trade_order_status($item->status) }}
                                                        </td>

                                                        <td>
                                                            <a href="{{route('tradeDetails', ($item->order_id))}}"><button class="btn deme-btn">{{__('View')}}</button></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">{{__('No data available')}}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                        @if(isset($items[0]))
                                            <div class="pull-right address-pagin">
                                                {{ $items->appends(request()->input())->links() }}
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

@endsection

@section('script')
@endsection
