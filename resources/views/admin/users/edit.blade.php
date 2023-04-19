@extends('admin.master',['menu'=>'users','sub_menu'=>'user'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('User management')}}</li>
                    <li class="active-item">{{__('Edit User')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <!-- User Management -->
    <div class="user-management profile">
        <div class="row">
            <div class="col-12">
                <div class="profile-info padding-40">
                    <div class="row">
                        <div class="col-xl-4 mb-xl-0 mb-4">
                            <div class="user-info text-center">
                                <div class="avater-img">
                                    <img src="{{show_image($user->id,'user')}}" alt="">
                                </div>
                                <h4>{{$user->first_name.' '.$user->last_name}}</h4>
                                <p>{{$user->email}}</p>
                            </div>
                            <ul class="profile-transaction">
                                <li class="profile-deposit">
                                    <p>{{__('Total Deposit')}}</p>
                                    <h4>{{total_deposit($user->id)}} </h4>
                                </li>
                                <li class="profile-withdrow">
                                    <p>{{__('Total Withdrawal')}}</p>
                                    <h4>{{total_withdrawal($user->id) }} </h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-8">
                            <form action="{{route('UserProfileUpdate')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{encrypt($user->id)}}">
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
                                            <small class="text-theme"><span><b>{{__('Note: ')}}</b>{{__('If you change the email, then user must verify his email again')}}</span></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('Contact Number')}}</label>
                                            <input id="realPhone" type="hidden" name="phone" value="{{$user->phone}}">
                                            <input id="telephone" type="text" class="form-control" >
                                            <small class="text-theme"><span><b>{{__('Note: ')}}</b>{{__('If you change the mobile number, then user must verify his number again')}}</span></small>
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
                                </div>
                                <button type="submit" class="button-primary theme-btn">{{__('Update')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->
@endsection

@section('script')
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
@endsection
