@extends('user.master',['menu' => 'offer'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="card cp-user-custom-card cp-user-deposit-card">
        <div class="row">
            <div class="col-sm-12">
                <div class="wallet-inner">
                    <div class="wallet-content card-body">
                        <div class="wallet-top cp-user-card-header-area">
                            <div class="title">
                                <div class="wallet-title text-center">
                                    <h4>
                                        <a href="{{route('createOffer')}}"><button class="btn theme-btn">{{__('Create Offer')}}</button></a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade  show active in"
                                 id="activity" role="tabpanel" aria-labelledby="activity-tab">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="activity-area">
                                            <div class="activity-top-area">
                                                <div class="cp-user-card-header-area">
                                                    <div class="title">
                                                        <h4 id="list_title">{{__('All Buy Offer List')}}</h4>
                                                    </div>
                                                    <div class="deposite-tabs cp-user-deposit-card">
                                                        <div class="activity-right text-right">
                                                            <ul class="nav cp-user-profile-nav mb-0">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" data-toggle="tab" onclick="$('#list_title').html('All Buy Offer List')" data-title="" href="#Deposit">{{__('Buy Offer')}}</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" data-toggle="tab" onclick="$('#list_title').html('All Sell Offer List')" href="#Withdraw">{{__('Sell Offer')}}</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="activity-list">
                                                <div class="tab-content">
                                                    <div id="Deposit" class="tab-pane fade show in active">

                                                        <div class="cp-user-wallet-table table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th>{{__('Buying Coin Type')}}</th>
                                                                    <th>{{__('Headline')}}</th>
                                                                    <th>{{__('Location')}}</th>
                                                                    <th>{{__('Rate')}}</th>
                                                                    <th>{{__('Status')}}</th>
                                                                    <th>{{__('Created At')}}</th>
                                                                    <th>{{__('Actions')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($buys[0]))
                                                                    @foreach($buys as $buy)
                                                                        <tr>
                                                                            <td>{{check_default_coin_type($buy->coin_type)}}</td>
                                                                            <td>{{\Illuminate\Support\Str::limit($buy->headline,10)}}</td>
                                                                            <td>{{countrylist($buy->country)}}</td>
                                                                            <td>
                                                                                @if($buy->rate_type == RATE_TYPE_DYNAMIC)
                                                                                    {{number_format($buy->rate_percentage,2)}} % {{price_rate_type($buy->price_type)}} {{__(' Market')}}
                                                                                @else
                                                                                    {{$buy->coin_rate.' '.$buy->currency}}
                                                                                @endif
                                                                            </td>
                                                                            <td>{{offer_active_status($buy->status)}}</td>
                                                                            <td>{{$buy->created_at}}</td>
                                                                            <td>
                                                                                <ul class="d-flex activity-menu">
                                                                                    <li class="viewuser"><a title="{{__('Edit')}}" href="{{route('editOffer', [($buy->unique_code),BUY])}}"><i class="fa fa-pencil"></i></a></li>

                                                                                    @if($buy->status != STATUS_ACTIVE)
                                                                                        <li class="deleteuser">
                                                                                            <a title="{{__('Activate')}}" href="#active_buy{{($buy->id)}}" data-toggle="modal">
                                                                                                <span><img src="{{asset("assets/admin/images/user-management-icons/activity/cancel.svg")}}" class="img-fluid" alt=""></span>
                                                                                            </a>
                                                                                        </li>
                                                                                        <div id="active_buy{{($buy->id)}}" class="modal fade delete" role="dialog">
                                                                                            <div class="modal-dialog modal-md">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header"><h6 class="modal-title">{{__('Activate')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                                                                                    <div class="modal-body"><p>{{__('Do you want to activate again ?')}}</p></div>
                                                                                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                                                                                        <a class="btn btn-success" href="{{route('activateOffer', [($buy->id),BUY])}}">{{__('Confirm')}}</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        <li class="deleteuser">
                                                                                            <a title="{{__('Deactivate')}}" href="#deactive_buy{{($buy->id)}}" data-toggle="modal">
                                                                                                <span><img src="{{asset("assets/admin/images/user-management-icons/activity/activate.svg")}}" class="img-fluid" alt=""></span>
                                                                                            </a>
                                                                                        </li>
                                                                                        <div id="deactive_buy{{($buy->id)}}" class="modal fade delete" role="dialog">
                                                                                            <div class="modal-dialog modal-md">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header"><h6 class="modal-title">{{__('Deactive')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                                                                                    <div class="modal-body"><p>{{__('Do you want to deactive ?')}}</p></div>
                                                                                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                                                                                        <a class="btn btn-danger" href="{{route('deactiveOffer', [($buy->id),BUY])}}">{{__('Confirm')}}</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </ul>
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
                                                            @if(isset($buys[0]))
                                                                <div class="pull-right address-pagin">
                                                                    {{ $buys->appends(request()->input())->links() }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div id="Withdraw" class="tab-pane fade in ">

                                                        <div class="cp-user-wallet-table table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th>{{__('Selling Coin Type')}}</th>
                                                                    <th>{{__('Headline')}}</th>
                                                                    <th>{{__('Location')}}</th>
                                                                    <th>{{__('Rate')}}</th>
                                                                    <th>{{__('Status')}}</th>
                                                                    <th>{{__('Created At')}}</th>
                                                                    <th>{{__('Actions')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($sells[0]))
                                                                    @foreach($sells as $sell)
                                                                        <tr>
                                                                            <td>{{check_default_coin_type($sell->coin_type)}}</td>
                                                                            <td>{{\Illuminate\Support\Str::limit($sell->headline,10)}}</td>
                                                                            <td>{{countrylist($sell->country)}}</td>
                                                                            <td>
                                                                                @if($sell->rate_type == RATE_TYPE_DYNAMIC)
                                                                                    {{number_format($sell->rate_percentage,2)}} % {{price_rate_type($sell->price_type)}} {{__(' Market')}}
                                                                                @else
                                                                                    {{number_format($sell->coin_rate,2).' '.$sell->currency}}
                                                                                @endif
                                                                            </td>
                                                                            <td>{{offer_active_status($sell->status)}}</td>
                                                                            <td>{{$sell->created_at}}</td>
                                                                            <td>
                                                                                <ul class="d-flex activity-menu">
                                                                                    <li class="viewuser"><a title="{{__('Edit')}}" href="{{route('editOffer', [($sell->unique_code), SELL])}}"><i class="fa fa-pencil"></i></a></li>
                                                                                    @if($sell->status != STATUS_ACTIVE)
                                                                                        <li class="deleteuser">
                                                                                            <a title="{{__('Activate')}}" href="#active_sell{{($sell->id)}}" data-toggle="modal">
                                                                                                <span><img src="{{asset("assets/admin/images/user-management-icons/activity/cancel.svg")}}" class="img-fluid" alt=""></span>
                                                                                            </a>
                                                                                        </li>
                                                                                        <div id="active_sell{{($sell->id)}}" class="modal fade delete" role="dialog">
                                                                                            <div class="modal-dialog modal-md">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header"><h6 class="modal-title">{{__('Activate')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                                                                                    <div class="modal-body"><p>{{__('Do you want to activate again ?')}}</p></div>
                                                                                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                                                                                        <a class="btn btn-success" href="{{route('activateOffer', [($sell->id), SELL])}}">{{__('Confirm')}}</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        <li class="deleteuser">
                                                                                            <a title="{{__('Deactivate')}}" href="#deactive_sell{{($sell->id)}}" data-toggle="modal">
                                                                                                <span><img src="{{asset("assets/admin/images/user-management-icons/activity/activate.svg")}}" class="img-fluid" alt=""></span>
                                                                                            </a>
                                                                                        </li>
                                                                                        <div id="deactive_sell{{($sell->id)}}" class="modal fade delete" role="dialog">
                                                                                            <div class="modal-dialog modal-md">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header"><h6 class="modal-title">{{__('Deactive')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                                                                                    <div class="modal-body"><p>{{__('Do you want to deactive ?')}}</p></div>
                                                                                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                                                                                        <a class="btn btn-danger" href="{{route('deactiveOffer', [($sell->id),SELL])}}">{{__('Confirm')}}</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="7"
                                                                            class="text-center">{{__('No data available')}}</td>
                                                                    </tr>
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                            @if(isset($sells[0]))
                                                                <div class="pull-right address-pagin">
                                                                    {{ $sells->appends(request()->input())->links() }}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
