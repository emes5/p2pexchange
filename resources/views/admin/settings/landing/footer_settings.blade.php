@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'footer_setting'])
@section('title','Footer settings')
@section('style')
@endsection
@section('content')
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Footer Settings')}}</li>
                    <li class="active-item">{{$title}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="user-management add-custom-page">
        <div class="row">
            <div class="col-12">
                <div class="header-bar">
                    <div class="table-title">
                        <h3>{{$title}}</h3>
                    </div>
                </div>
                <div class="profile-info-form">
                    <form action="{{route('landingPageFooterSave')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Footer Description')}}</label>
                                    <input type="text" class="form-control" id="footer_description" name="footer_description" placeholder="{{__('Footer Description')}}" @if(isset($settings['footer_description'])) value="{{$settings['footer_description']}}" @else value="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Newsletter Description')}}</label>
                                    <input type="text" class="form-control" id="newsletter_description" name="newsletter_description" placeholder="{{__('Newsletter Description')}}" @if(isset($settings['newsletter_description'])) value="{{$settings['newsletter_description']}}" @else value="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Facebook Link')}}</label>
                                    <input type="text" class="form-control" id="facebook_link" name="facebook_link" placeholder="{{__('Facebook Link')}}" @if(isset($settings['facebook_link'])) value="{{$settings['facebook_link']}}" @else value="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Twitter Link')}}</label>
                                    <input type="text" class="form-control" id="twitter_link" name="twitter_link" placeholder="{{__('Twitter Link')}}" @if(isset($settings['twitter_link'])) value="{{$settings['twitter_link']}}" @else value="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('LinkedIn Link')}}</label>
                                    <input type="text" class="form-control" id="linkedin_link" name="linkedin_link" placeholder="{{__('LinkedIn Link')}}" @if(isset($settings['linkedin_link'])) value="{{$settings['linkedin_link']}}" @else value="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Instagram Link')}}</label>
                                    <input type="text" class="form-control" id="instagram_link" name="instagram_link" placeholder="{{__('Instagram Link')}}" @if(isset($settings['instagram_link']))value="{{$settings['instagram_link']}}" @else value="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Contact Address')}}</label>
                                    <input type="text" class="form-control" id="contact_address" name="contact_address" placeholder="{{__('Contact Address')}}" @if(isset($settings['contact_address'])) value="{{$settings['contact_address']}}" @else value="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Email')}}</label>
                                    <input type="email" class="form-control" id="site_email" name="site_email" placeholder="{{__('Email')}}" @if(isset($settings['site_email'])) value="{{$settings['site_email']}}" @else value="" @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Mobile')}}</label>
                                    <input type="text" class="form-control" id="site_mobile" name="site_mobile" placeholder="{{__('Mobile')}}" @if(isset($settings['site_mobile'])) value="{{$settings['site_mobile']}}" @else value="" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12 mt-0">
                                <div class="form-group">
                                    <label>{{__('Select Landing Page')}}</label>
                                    <select name="landing_page_id" id="landing_page_id" class="form-control">
                                        @foreach($pages as $page)
                                            <option value="{{$page->id}}" @if($page->status) selected @endif>{{$page->page_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-0 feature_div">
                                {!! $feature_html !!}
                            </div>
                            <div class="col-lg-6 col-12 mt-0 custom_div">
                                {!! $custom_page_html !!}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn add-faq-btn">{{__('Save')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- .user-area end -->
@endsection
<script src="{{asset('assets/landing/custom/assets/js/sweetalert/sweetalert2.all.min.js')}}"></script>
<link href="{{asset('assets/landing/custom/assets/js/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{asset('assets/landing/custom/assets/js/jquery-3.6.0.min.js')}}"></script>


<script>
    $(document).ready(function()
    {
        $(document).on('input','#landing_page_id',function (e){
            const page_id = $(this).val();
            var url = "{{route('getlandingFooterInfo')}}";
            var data = {
                '_token': '{{ csrf_token() }}',
                'id': page_id,
            };
            $.ajax({
                url : url,
                type : 'POST',
                data : data,
                dataType:'json',
                success : function(data) {
                    $('.feature_div').html(data.feature_html);
                    $('.custom_div').html(data.custom_page_html);
                    $('.selectpicker').selectpicker();
                },
                error : function(request,error)
                {
                    //alert('Error');
                }
            });

        });
    });
</script>


@section('script')
@endsection

