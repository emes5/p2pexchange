@include('email.header_new')

<p>{{__('Hello')}}, {{ $data->first_name.' '.$data->last_name }}</p>
<p>
    {{__('We need to verify your email address. In order to verify your account please click on the following link or paste the link on address bar of your browser and hit -')}}
</p>
<p>
    <a style="text-decoration: none;background: #4A9A4D;color: #fff;padding: 5px 10px;border-radius: 3px;" href="{{route('verifyWeb').'?token='.encrypt($key).'email'.encrypt($data->email)}}">{{__('Verify')}}</a>
</p>
<p>{{__('Or')}}</p>
<p>   {{__('Your')}} {{allSetting()['app_title']}} {{__('email verification code is')}} - {{$key}}.
    <br>
</p>
<p>
    {{__('Thanks a lot for being with us.')}} <br/>
    {{allSetting()['app_title']}}
</p>
@include('email.footer_new')
