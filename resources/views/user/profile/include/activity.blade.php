<div class="card cp-user-custom-card">
    <div class="card-body">
        <div class="cp-user-profile-header">
            <h5>{{__('All Activity List')}}</h5>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="cp-user-wallet-table table-responsive">
                    <table id="activity-tbl" class="table table-borderless cp-user-custom-table"
                           width="100%">
                        <thead>
                        <tr>
                            <th class="all">{{__('Action')}}</th>
                            <th class="desktop">{{__('Source')}}</th>
                            <th class="desktop">{{__('IP Address')}}</th>
                            {{-- <th class="all">Location</th> --}}
                            <th class="all">{{__('Updated At')}}</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
