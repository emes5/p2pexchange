<div class="card cp-user-custom-card">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="cp-user-profile-header">
                    <h5>{{__('Phone Verification')}}</h5>
                </div>
                <div class="cp-user-profile-info">
                    <form method="post" action="{{route('phoneVerify')}}">
                        @csrf
                        <div class="form-group">
                            <label for="number">{{__('Phone number')}}</label>
                            <div class="code-list">
                                @if(!empty($user->phone))
                                    <input type="text" readonly value="{{Auth::user()->phone}}"
                                           class="form-control" id="">
                                    @if((Auth::user()->phone_verified == 0 )  && (!empty(\Illuminate\Support\Facades\Cookie::get('code'))))
                                        <a href="{{route('sendSMS')}}"
                                           class="btn btn-primary mt-3">{{__('Resend SMS')}}</a>
                                        <p>{{__('Did not receive code?')}}</p>
                                    @elseif(Auth::user()->phone_verified == 1 )
                                        <span class="verified">{{__('Verified')}}</span>
                                    @else
                                        <a href="{{route('sendSMS')}}"
                                           class="btn btn-primary mt-3">{{__('Send SMS')}}</a>
                                    @endif
                                @else
                                    <p>{{__('Please add mobile no. first from edit profile')}}</p>
                                @endif
                            </div>
                        </div>
                        @if((Auth::user()->phone_verified == 0) && (!empty(\Illuminate\Support\Facades\Cookie::get('code'))))
                            <div class="form-group">
                                <label for="number">{{__('Verify Code')}}</label>
                                <div class="code-list">
                                    <input name="code" type="text" min="" max=""
                                           class="form-control" id="">
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn profile-edit-btn phn-verify-btn">{{__('Verify')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
