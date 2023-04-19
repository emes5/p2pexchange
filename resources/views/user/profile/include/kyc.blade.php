<div class="card cp-user-custom-card idverifycard">
    <div class="card-body">
        <div class="cp-user-profile-header">
            <h5>{{__('Select Your ID Type')}}</h5>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="cp-user-profile-info-id-type">
                    <div class="id-card-type">
                        <div class="id-card" data-toggle="modal"
                             data-target=".cp-user-idverifymodal">
                            <img src="{{asset('assets/user/images/cards/nid.svg')}}"
                                 class="img-fluid" alt="">
                        </div>
                        <div class="card-bottom">
                            @if((!empty($nid_back ) && !empty($nid_front)) && (($nid_back->status == STATUS_SUCCESS) && ($nid_front->status == STATUS_SUCCESS)))
                                <span class="text-success">{{__('Approved')}}</span>
                            @elseif((!empty($nid_back ) && !empty($nid_front)) && (($nid_back->status == STATUS_REJECTED) && ($nid_front->status == STATUS_REJECTED)))
                                <span class="text-danger">{{__('Rejected')}}</span>
                            @elseif((!empty($nid_back ) && !empty($nid_front)) && (($nid_back->status == STATUS_PENDING) && ($nid_front->status == STATUS_PENDING)))
                                <span class="text-warning">{{__('Pending')}}</span>
                            @else
                                <span class="text-warning">{{__('Not Submitted')}}</span>
                            @endif
                            <h5>{{__('National Id Card')}}</h5>
                        </div>
                    </div>
                    <div class="id-card-type">
                        <div class="id-card" data-toggle="modal"
                             data-target=".cp-user-passwordverifymodal">
                            <img src="{{asset('assets/user/images/cards/passport.svg')}}"
                                 class="img-fluid" alt="">
                        </div>
                        <div class="card-bottom">
                            @if((!empty($pass_back ) && !empty($pass_front)) && (($pass_back->status == STATUS_SUCCESS) && ($pass_front->status == STATUS_SUCCESS)))
                                <span class="text-success">{{__('Approved')}}</span>
                            @elseif((!empty($pass_back ) && !empty($pass_front)) && (($pass_back->status == STATUS_REJECTED) && ($pass_front->status == STATUS_REJECTED)))
                                <span class="text-danger">{{__('Rejected')}}</span>

                            @elseif((!empty($pass_back ) && !empty($pass_front)) && (($pass_back->status == STATUS_PENDING) && ($pass_front->status == STATUS_PENDING)))
                                <span class="text-warning">{{__('Pending')}}</span>
                            @else
                                <span class="text-warning">{{__('Not Submitted')}}</span>
                            @endif
                            <h5>{{__('Passport')}}</h5>
                        </div>
                    </div>
                    <div class="id-card-type">
                        <div class="id-card" data-toggle="modal"
                             data-target=".cp-user-driververifymodal">
                            <img src="{{asset('assets/user/images/cards/driving-license.svg')}}"
                                 class="img-fluid" alt="">
                        </div>
                        <div class="card-bottom">
                            @if((!empty($drive_back ) && !empty($drive_front)) && (($drive_back->status == STATUS_SUCCESS) && ($drive_front->status == STATUS_SUCCESS)))
                                <span class="text-success">{{__('Approved')}}</span>
                            @elseif((!empty($drive_back ) && !empty($drive_front)) && (($drive_back->status == STATUS_REJECTED) && ($drive_front->status == STATUS_REJECTED)))
                                <span class="text-danger">{{__('Rejected')}}</span>
                            @elseif((!empty($drive_back ) && !empty($drive_front)) && (($drive_back->status == STATUS_PENDING) && ($drive_front->status == STATUS_PENDING)))
                                <span class="text-warning">{{__('Pending')}}</span>
                            @else
                                <span class="text-warning">{{__('Not Submitted')}}</span>
                            @endif
                            <h5>{{__('Driving License')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
