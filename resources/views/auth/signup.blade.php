@extends('auth.master',['menu'=>'dashboard'])
@section('title', isset($title) ? $title : __('Signup'))

@section('content')
    <div class="user-content-wrapper">
        <div>
            <div class="user-form">
                <div class="right">
                    <div class="form-top">
                        <a class="auth-logo" href="{{route('home')}}">
                            <img src="{{show_image(1,'login_logo')}}" class="img-fluid" alt="">
                        </a>
                        <p>{{__('Sign up your account')}}</p>
                    </div>
                    {{ Form::open(['route' => 'signUpProcess', 'files' => true]) }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('First Name')}}<span class="text-danger">*</span></label>
                                <input type="text" name="first_name" value="{{old('first_name')}}" class="form-control" placeholder="{{__('Your first name here')}}">
                                @if ($errors->has('first_name'))
                                    <p class="invalid-feedback">{{ $errors->first('first_name') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Last Name')}}<span class="text-danger">*</span></label>
                                <input type="text" name="last_name" value="{{old('last_name')}}" class="form-control" placeholder="{{__('Your last name here')}}">
                                @if ($errors->has('last_name'))
                                    <p class="invalid-feedback">{{ $errors->first('last_name') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Nick Name')}}<span class="text-danger">*</span></label>
                                <input type="text" name="username" value="{{old('username')}}" class="form-control" placeholder="{{__('Unique username')}}">
                                @if ($errors->has('username'))
                                    <p class="invalid-feedback">{{ $errors->first('username') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Country')}}<span class="text-danger">*</span></label>
                                <select name="country" id="" class="form-control">
                                    <option value="">{{__('Select')}}</option>
                                    @if(!empty(countrylist()))
                                        @foreach(countrylist() as $key => $value)
                                            <option value="{{$key}}"
                                                    @if(old('country') == $key) selected @endif>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('country'))
                                    <p class="invalid-feedback">{{ $errors->first('country') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('Email Address')}}<span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="{{__('Your email here')}}">
                                @if ($errors->has('email'))
                                    <p class="invalid-feedback">{{ $errors->first('email') }} </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('Password')}}<span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control form-control-password look-pass" placeholder="{{__('Your password here')}}">
                                @if ($errors->has('password'))
                                    <p class="invalid-feedback">{{ $errors->first('password') }} </p>
                                @endif
                                <span class="eye rev"><i class="fa fa-eye-slash toggle-password"></i></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('Confirm Password')}}<span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control form-control-password look-pass-1" placeholder="{{__('Your confirm password here')}}">
                                @if ($errors->has('password_confirmation'))
                                    <p class="invalid-feedback">{{ $errors->first('password_confirmation') }} </p>
                                @endif
                                <span class="eye rev-1"><i class="fa fa-eye-slash toggle-password"></i></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @if(isset(allsetting()['google_recapcha']) && allsetting()['google_recapcha'])
                                <div class="form-group">
                                    <label>{{__('')}}</label>
                                    {!! app('captcha')->display() !!}
                                    @error('g-recaptcha-response')
                                    <p class="invalid-feedback">{{ $message }} </p>
                                    @enderror
                                </div>
                            @endif

                            @if( app('request')->input('ref_code'))
                                {{Form::hidden('ref_code', app('request')->input('ref_code') )}}
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary nimmu-user-sibmit-button">{{__('Signup')}}</button>
                    </div>
                    {{ Form::close() }}
                    <div class="form-bottom text-center">
                        <p>{{__('Already have an account ?')}} <a href="{{route('login')}}">{{__('Return to Sign In')}}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".toggle-password").on('click', function () {
            $(this).toggleClass("fa-eye-slash fa-eye");
        });
        $(".rev").on('click', function () {
            var $pwd = $(".look-pass");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });

        $(".rev-1").on('click', function () {
            var $pwd = $(".look-pass-1");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });
    </script>
@endsection
