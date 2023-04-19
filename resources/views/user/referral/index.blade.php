@extends('user.master',['menu'=>'referral'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <ul class="nav cp-user-profile-nav" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-id="invite-contact-tab"
                       id="invite-contact-tab" data-toggle="pill" href="#pills-invite-contact" role="tab"
                       aria-controls="pills-invite-contact" aria-selected="true">
                                        <span class="cp-user-img">
                                            <img src="{{asset('assets/user/images/profile-icons/profile.svg')}}"
                                                 class="img-fluid img-normal" alt="">
                                            <img src="{{asset('assets/user/images/profile-icons/active/profile.svg')}}"
                                                 class="img-fluid img-active" alt="">
                                        </span>
                        {{__('Invite Contact')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-id="my-referrals-tab"
                       id="pills-my-referrals-tab" data-toggle="pill" href="#pills-my-referrals" role="tab"
                       aria-controls="pills-my-referrals" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/phone-verify.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/phone-verify.svg')}}"
                                         class="img-fluid img-active" alt=""
                                    ></span>
                        {{__('My Referrals')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-id="my-references-tab"
                       id="pills-my-references-tab" data-toggle="pill" href="#pills-my-references" role="tab"
                       aria-controls="pills-my-references" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/id-verify.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/id-verify.svg')}}"
                                         class="img-fluid img-active" alt="">
                                </span>
                        {{__('My References')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-id="my-earnings-tab"
                       id="pills-my-earnings-tab" data-toggle="pill" href="#pills-my-earnings" role="tab"
                       aria-controls="pills-my-earnings" aria-selected="true">
                                <span class="cp-user-img">
                                    <img src="{{asset('assets/user/images/profile-icons/reset-pass.svg')}}"
                                         class="img-fluid img-normal" alt="">
                                    <img src="{{asset('assets/user/images/profile-icons/active/reset-pass.svg')}}"
                                         class="img-fluid img-active" alt="">
                                </span>
                        {{__('Earning')}}
                    </a>
                </li>

            </ul>
            <div class="tab-content cp-invite-contact-tab-content" id="pills-tabContent">
                <div class="tab-pane fade show show active in" id="pills-invite-contact"
                     role="tabpanel" aria-labelledby="pills-invite-contact-tab">
                    @include('user.referral.invite_contact')
                </div>
                <div class="tab-pane fade " id="pills-my-referrals"
                     role="tabpanel" aria-labelledby="pills-my-referrals-tab">
                    @include('user.referral.my_referrals')
                </div>
                <div class="tab-pane fade " id="pills-my-references"
                     role="tabpanel" aria-labelledby="pills-my-references-tab">
                    @include('user.referral.my_references')
                </div>
                <div class="tab-pane fade"
                     id="pills-my-earnings" role="tabpanel" aria-labelledby="pills-my-earnings-tab">
                    @include('user.referral.my_earnings')
                </div>

            </div>


        </div>
    </div>
    <div class="row">
        <div class="col-12">






        </div>
    </div>
@endsection

@section('script')
    <script>
        function copy_clipboard() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("Copy");
        }

        function CopyUrl() {

            /* Get the text field */
            var copyText = document.getElementById("url");

            /* Select the text field */
            copyText.select();

            /* Copy the text inside the text field */
            document.execCommand("copy");
            VanillaToasts.create({
                text: '{{__('URL copied successfully')}}',
                type: 'success',
                timeout: 3000
            });
        }

        $('#table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: '{{route('myReferralEarning')}}',
            order: [4, 'desc'],
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "child_id","orderable": false},
                {"data": "amount","orderable": false},
                {"data": "coin_type","orderable": false},
                {"data": "status","orderable": false},
                {"data": "created_at","orderable": false},
            ],
        });
    </script>
@endsection
