<div class="card cp-user-custom-card">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="cp-user-profile-header">
                    <h5>{{__('Reset Password')}}</h5>
                </div>

            </div>
            <div class="col-lg-9">
                <div class="cp-user-profile-info">
                    <form method="POST" action="{{route('changePasswordSave')}}">
                        @csrf
                        <div class="form-group">
                            <label>{{__('Current Password')}}</label>
                            <input name="password" type="password"
                                   placeholder="{{__('Current Password')}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{__('New Password')}}</label>
                            <input name="new_password" type="password"
                                   placeholder="{{__('New Password')}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{__('Confirm New Password')}}</label>
                            <input name="confirm_new_password" type="password"
                                   placeholder="{{__('Re Enter New Password')}}"
                                   class="form-control">
                        </div>
                        @if(isset(allsetting()['google_recapcha']) && allsetting()['google_recapcha'])
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('')}}</label>
                                    {!! app('captcha')->display() !!}
                                    @error('g-recaptcha-response')
                                    <p class="invalid-feedback">{{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="form-group m-0">
                            <button class="btn profile-edit-btn"
                                    type="submit">{{__('Change Password')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
