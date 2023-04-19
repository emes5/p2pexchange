<div class="row">
    <div class="col-xl-4 mb-xl-0 mb-4">
        <div class="card cp-user-custom-card">
            <div class="card-body">
                <div class="user-profile-area">
                    <div class="user-profile-img">
                        <img src="{{show_image($user->id,'user')}}" class="img-fluid" alt="">
                    </div>
                    <form enctype="multipart/form-data" method="post"
                          action="{{route('uploadProfileImage')}}">
                        @csrf
                        <div class="user-cp-user-profile-info">
                            <input type="file" name="file_one" id="upload-user-img">
                            <label for="upload-user-img" class="upload-user-img">
                                {{__('Upload New Image')}}
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card cp-user-custom-card">
            <div class="card-body">
                <div class="cp-user-profile-header">
                    <h5>{{__('Edit Profile Information')}}</h5>
                </div>
                <div class="cp-user-profile-info">
                    <form action="{{route('userProfileUpdate')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('First Name')}}</label>
                                    <input type="text" name="first_name" value="{{$user->first_name}}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Last Name')}}</label>
                                    <input type="text" name="last_name" value="{{$user->last_name}}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Nick Name')}}</label>
                                    <input type="text" name="username" value="{{$user->username}}"
                                           class="form-control">
                                    <small class="text-theme"><span><b>{{__('Note: ')}}</b>{{__('Nick name must be unique')}}</span></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Email')}}</label>
                                    <input type="text" name="email" value="{{$user->email}}" class="form-control">
                                    <small class="text-theme"><span><b>{{__('Note: ')}}</b>{{__('If you change the email, then you must verify your email again')}}</span></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Contact Number')}}</label>
                                    <input id="realPhone" type="hidden" name="phone" value="{{$user->phone}}">
                                    <input id="telephone" type="text" class="form-control" >
                                    <small class="text-theme"><span><b>{{__('Note: ')}}</b>{{__('If you change the mobile number, then you must verify your number again')}}</span></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Country')}}</label>
                                    <select name="country" id="" class="form-control">
                                        @foreach(countrylist() as $key => $value)
                                            <option value="{{$key}}"
                                                    @if(isset($user->country) && ($user->country == $key)) selected @endif>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Gender')}}</label>
                                    <select class="form-control" name="gender" id="">
                                        <option @if($user->gender == 1) selected
                                                @endif value="1">{{__('Male')}}</option>
                                        <option @if($user->gender == 2) selected
                                                @endif value="2">{{__('Female')}}</option>
                                        <option @if($user->gender == 3) selected
                                                @endif value="3">{{__('Others')}}</option>
                                    </select>
                                </div>
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
                        </div>

                        <div class="form-group m-0">
                            <button class="btn profile-edit-btn"
                                    type="submit">{{__('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/common/input_master_telephone/build/js/intlTelInput.min.js') }}"></script>
<script>
    let phone = document.getElementById("realPhone");
    let subPhone = document.getElementById("telephone");
    let daileCode = null ;
    let a =  window.intlTelInput(subPhone, ({
        // initialCountry: "{{$user->country ? $user->country : 'US'}}",
        separateDialCode: true,
    }));
    @if(!empty($user->phone))
    a.setNumber("+"+"{{$user->phone}}");
    @endif
    function getDailer(){
        let b = a.getSelectedCountryData();
        let code = b.dialCode;
        daileCode = code;
    }
    document.getElementById("telephone").addEventListener("countrychange", function() {
        getDailer();
        fillPhone();
    });
    document.getElementById("telephone").addEventListener("keydown", function() {
        phone.value ='';
    });
    document.getElementById("telephone").addEventListener("keyup", function() {
        fillPhone()
    });
    function fillPhone(){
        let sub = subPhone.value;
        let num = daileCode + sub;
        phone.value = num;
    }
    getDailer();
</script>
