<div class="header-bar">
    <div class="table-title">
        <h3>{{__('Terms and Conditions')}}</h3>
    </div>
</div>
<div class="profile-info-form">
    <form action="{{route('adminSaveTermsCondition')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12 col-12 mt-20">
                <div class="form-group">
                    <label for="#">{{__('Terms and Conditions')}}</label>
                    <textarea name="terms_condition" id="btEditor" cols="30" rows="10" class="form-control">{{isset($settings['terms_condition']) ? $settings['terms_condition'] : ''}}</textarea>
                </div>
            </div>
            <div class="col-lg-12 col-12 mt-20">
                <div class="form-group">
                    <label for="#">{{__('Privacy Policy')}}</label>
                    <textarea name="privacy_policy" id="btEditor2" cols="30" rows="10" class="form-control">{{isset($settings['privacy_policy']) ? $settings['privacy_policy'] : ''}}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-12 mt-20">
                <button type="submit" class="button-primary theme-btn">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>
