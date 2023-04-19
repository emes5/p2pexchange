<div class="card cp-user-custom-card mt-5">
    <div class="card-body">
        <div class="cp-user-card-header-area">
            <h4>{{__('My References')}}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="cp-user-myreferral">
                    <div class="table-responsive">
                        <table class="table dataTable cp-user-custom-table table-borderless text-center" width="100%">
                            <thead>
                            <tr>
                                <th class="">{{ __('Full Name') }}</th>
                                <th class="">{{ __('Email') }}</th>
                                <th class="">{{ __('Level') }}</th>
                                <th class="">{{ __('Joining Date') }}</th>
                                <th class="">{{ __('Balance') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($referrals))
                                @foreach($referrals as $data)
                                    <tr>
                                        <td>{{ $data['full_name'] }}</td>
                                        <td class="email-case">{{ $data['email'] }}</td>
                                        <td>{{ $data['level'] }}</td>
                                        <td>{{ $data['joining_date'] }}</td>
                                        <td>{{ user_balance($data['id']) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=5 class="text-center"><b>{{__('No data available')}}</b></td>
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
