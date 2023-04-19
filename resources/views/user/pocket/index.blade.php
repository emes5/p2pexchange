@extends('user.master',['menu'=>'pocket'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card cp-user-custom-card cp-user-wallet-card">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <div class="cp-user-title">
                            <h4>{{__('My Wallet')}}</h4>
                        </div>
                        <div class="buttons">
                            <button class="btn cp-user-add-pocket" data-toggle="modal" data-target="#add-pocket">{{__('Add Wallet')}}</button>
                        </div>
                    </div>
                    <div class="cp-user-wallet-table">
                        <table class="table table-borderless cp-user-custom-table" width="100%">
                            <thead>
                            <tr>
                                <th class="all">{{__('Name')}}</th>
                                <th class="all">{{__('Coin Type')}}</th>
                                <th class="desktop">{{__('Balance')}}</th>
                                <th class="desktop">{{__('Updated At')}}</th>
                                <th class="all">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($wallets[0]))
                                @foreach($wallets as $wallet)
                                    <tr>
                                        <td>{{ $wallet->name }}</td>
                                        <td>{{ check_default_coin_type($wallet->coin_type) }}</td>
                                        <td>{{ $wallet->balance }}</td>
                                        <td>{{ $wallet->updated_at }}</td>
                                        <td>
                                            <ul class="d-flex align-items-center">
                                                @if(is_primary_wallet($wallet->id, $wallet->coin_type) == 0)
                                                    <li>
                                                        <a title="{{__('Make primary')}}" href="{{route('makeDefaultAccount',[$wallet->id, $wallet->coin_type])}}">
                                                            <img src="{{asset('assets/user/images/wallet-table-icons/Key.svg')}}" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                @endif
                                                @if($wallet->coin_type == DEFAULT_COIN_TYPE)
                                                    <li>
                                                        <a title="{{__('Deposit')}}" href="{{route('walletDetails',$wallet->id)}}?q=deposit">
                                                            <img src="{{asset('assets/user/images/wallet-table-icons/wallet.svg')}}" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a title="{{__('withdraw')}}" href="{{route('withdrawalDefaultCoin')}}">
                                                            <img src="{{asset('assets/user/images/wallet-table-icons/send.svg')}}" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a title="{{__('Activity log')}}" href="{{route('walletDetails',$wallet->id)}}?q=activity">
                                                            <img src="{{asset('assets/user/images/wallet-table-icons/share.svg')}}" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a title="{{__('Deposit')}}" href="{{route('walletDetails',$wallet->id)}}?q=deposit">
                                                            <img src="{{asset('assets/user/images/wallet-table-icons/wallet.svg')}}" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a title="{{__('withdraw')}}" href="{{route('walletDetails',$wallet->id)}}?q=withdraw">
                                                            <img src="{{asset('assets/user/images/wallet-table-icons/send.svg')}}" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a title="{{__('Activity log')}}" href="{{route('walletDetails',$wallet->id)}}?q=activity">
                                                            <img src="{{asset('assets/user/images/wallet-table-icons/share.svg')}}" class="img-fluid" alt="">
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add pocket modal -->
    <div class="modal fade cp-user-move-coin-modal" id="add-pocket" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{asset('assets/user/images/close.svg')}}" class="img-fluid" alt="">
                </button>
                <div class="modal-body">
                    <h3>{{__('Want To Add New Wallet?')}}</h3>
                    <form method="post" action="{{route('createWallet')}}" id="walletCreateForm">
                        @csrf
                        <div class="form-group">
                            <label>{{__('Wallet Name')}}</label>
                            <input type="text" name="wallet_name" required class="form-control" placeholder="{{__('Write Your Wallet Name')}}">
                        </div>
                        <div class="form-group">
                            <label>{{__('Coin Type')}}</label>
                            <select name="coin_type" id="" required class="form-control">
                                <option value="">{{__('Select coin type')}}</option>
                                @if(isset($coins[0]))
                                    @foreach($coins as $coin)
                                        <option value="{{$coin->type}}"> {{check_default_coin_type($coin->type)}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="btn btn-block cp-user-move-btn">{{__('Add Wallet')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- move coin modal -->

@endsection

@section('script')
@endsection
