<div class="row">
    <div class="col-lg-12">
        <div class="activity-area">
            <div class="activity-top-area">
                <div class="cp-user-card-header-area">
                    <div class="title">
                        <h4 id="list_title">{{__('All Deposit List')}}</h4>
                    </div>
                    <div class="deposite-tabs cp-user-deposit-card">
                        <div class="activity-right text-right">
                            <ul class="nav cp-user-profile-nav mb-0">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" onclick="$('#list_title').html('All Deposit List')" data-title="" href="#Deposit">{{__('Deposit')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" onclick="$('#list_title').html('All Withdrawal List')" href="#Withdraw">{{__('Withdraw')}}</a>
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
                                    <th>{{__('Address')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Fees')}}</th>
                                    <th>{{__('Transaction Hash')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Created At')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($histories[0]))
                                    @foreach($histories as $history)
                                        <tr>
                                            <td>{{$history->address}}</td>
                                            <td>{{$history->amount}}</td>
                                            <td>{{$history->fees}}</td>
                                            <td>{{$history->transaction_id}}</td>
                                            <td>{{deposit_status($history->status)}}</td>
                                            <td>{{$history->created_at}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5"
                                            class="text-center">{{__('No data available')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="Withdraw" class="tab-pane fade in ">

                        <div class="cp-user-wallet-table table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{__('Address')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Fees')}}</th>
                                    <th>{{__('Transaction Hash')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Created At')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($withdraws[0]))
                                    @foreach($withdraws as $withdraw)
                                        <tr>
                                            <td>{{$withdraw->address}}</td>
                                            <td>{{$withdraw->amount}}</td>
                                            <td>{{$withdraw->fees}}</td>
                                            <td>{{$withdraw->transaction_hash}}</td>
                                            <td>{{deposit_status($withdraw->status)}}</td>
                                            <td>{{$withdraw->created_at}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5"
                                            class="text-center">{{__('No data available')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
