@extends('user.master',['menu'=>'pocket'])
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
                                    <h4>{{$wallet->name}}</h4>
                                </div>
                            </div>
                            <div class="tab-navbar">
                                <div class="tabe-menu">
                                    <ul class="nav cp-user-profile-nav mb-0" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link wallet {{($active == 'deposit') ? 'active' : ''}}"
                                               id="diposite-tab"
                                               href="{{route('walletDetails',$wallet->id)}}?q=deposit"
                                               aria-controls="diposite" aria-selected="true">
                                                <i class="flaticon-wallet"></i> {{__('Deposit')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link send  {{($active == 'withdraw') ? 'active' : ''}}"
                                               id="withdraw-tab"
                                               href="{{route('withdrawalDefaultCoin')}}"
                                               aria-controls="withdraw" aria-selected="false">
                                                <i class="flaticon-send"> </i> {{__('Withdraw')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link share  {{($active == 'activity') ? 'active' : ''}}"
                                               id="activity-tab"
                                               href="{{route('walletDetails',$wallet->id)}}?q=activity"
                                               aria-controls="activity" aria-selected="false">
                                                <i class="flaticon-share"> </i> {{__('Activity log')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade   {{($active == 'deposit') ? 'show active' : ''}} in"
                                 id="diposite" role="tabpanel"
                                 aria-labelledby="diposite-tab">
                                @include('user.pocket.include.deposit_default')
                            </div>
                            <div class="tab-pane fade {{($active == 'withdraw') ? 'show active' : ''}} in" id="withdraw"
                                 role="tabpanel" aria-labelledby="withdraw-tab">
                                @include('user.pocket.include.withdrawal_default')
                            </div>
                            <div class="tab-pane fade  {{($active == 'activity') ? 'show active' : ''}} in"
                                 id="activity" role="tabpanel" aria-labelledby="activity-tab">
                                @include('user.pocket.include.activity')
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
        function withDrawBalance() {
            var g2fCheck = '{{\Illuminate\Support\Facades\Auth::user()->google2fa_secret}}';


            if (g2fCheck.length > 1) {
                var frm = $('#withdrawFormData');

                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(),
                    success: function (data) {
                        if (data.success == true) {
                            $('#g2fcheck').modal('show');

                        } else {
                            VanillaToasts.create({
                                // title: 'Message Title',
                                text: data.message,
                                type: 'warning',
                                timeout: 3000

                            });
                        }

                    },
                    error: function (data) {

                    },
                });
            } else {
                VanillaToasts.create({
                    text: "{{__('Your google authentication is disabled,please enable it')}}",
                    type: 'warning',
                    timeout: 3000

                });
            }

        }

        <!-- copy_to_clip -->
        $('.copy_to_clip').on('click', function () {
            /* Get the text field */
            var copyFrom = document.getElementById("addressVal");

            /* Select the text field */
            copyFrom.select();

            /* Copy the text inside the text field */
            document.execCommand("copy");

            VanillaToasts.create({
                title: 'Copied the text',
                // text: copyFrom.value,
                type: 'success',
                timeout: 3000,
                positionClass: 'topCenter'
            });
        });
    </script>
@endsection
