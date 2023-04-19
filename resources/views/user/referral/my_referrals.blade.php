<div class="card cp-user-custom-card mt-5">
    <div class="card-body">
        <div class="cp-user-card-header-area">
            <h4>{{__('My Referrals')}}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="cp-user-myreferral">
                    <div class="table-responsive">
                        <table class="table dataTable cp-user-custom-table table-borderless text-center" width="100%">
                            <thead>
                            <tr>
                                @for($i = 1; $i <= 3; $i++)
                                    <th class="referral-level" rowspan="1" colspan="1" aria-label="{{__('Level'). ' '. $i }}">
                                        {{__('Level'). ' '. $i }}
                                    </th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="" role="" class="odd">
                                @for($i = 1; $i <= 3; $i++)
                                    <td>{{$referralLevel[$i]}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td colspan="{{$max_referral_level}}"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
