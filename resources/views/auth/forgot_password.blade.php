@extends('auth.master',['menu'=>'dashboard'])
@section('title', isset($title) ? $title : __('Forgot Password'))

@section('content')
    <div class="user-content-wrapper">
        <div>
            <div class="user-form">
                <div class="right">
                    <div class="form-top">
                        <a class="auth-logo" href="{{route('home')}}">
                            <img src="{{show_image(1,'login_logo')}}" class="img-fluid" alt="">
                        </a>
                        <p>{{__('Forgot Password')}}</p>
                    </div>
                    {{Form::open(['route' => 'sendForgotMail', 'files' => true])}}
                    <div class="form-group">
                        <label>{{__('Email address')}}</label>
                        <input type="email" name="email" class="form-control" placeholder="{{__('Your email here')}}">
                    </div>
                    @if(isset(allsetting()['google_recapcha']) && allsetting()['google_recapcha'])
                        <div class="form-group">
                            <label>{{__('')}}</label>
                            {!! app('captcha')->display() !!}
                            @error('g-recaptcha-response')
                            <p class="invalid-feedback">{{ $message }} </p>
                            @enderror
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary nimmu-user-sibmit-button">{{__('Send')}}</button>
                    {{ Form::close() }}
                    <div class="form-bottom text-center">
                        <p>{{__('Return to ')}} <a href="{{route('login')}}">{{__('Sign in')}}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
