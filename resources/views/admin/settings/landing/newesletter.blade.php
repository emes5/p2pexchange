<div class="header-bar">
    <div class="table-title">
        <h3>{{__('Newsletter Section')}}</h3>
    </div>
</div>
<div class="profile-info-form">
    <form action="{{route('updateLandingSettings')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tab" value="newsletter">
        <div class="row">
            <div class="col-lg-12 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Newsletter Section Title')}}</label>
                    <input class="form-control" type="text" name="newsletter_section_title" value="{{isset($settings['newsletter_section_title']) ? $settings['newsletter_section_title'] : ''}}">
                </div>
            </div>
        </div>
        <div class="uplode-img-list">
            <div class="row">
                <div class="col-lg-6 mt-20">
                    <div class="form-group">
                        <label>{{__('Newsletter Section Short Description')}}</label>
                        <textarea class="form-control" name="newsletter_section_des" id=""  rows="7">{{isset($settings['newsletter_section_des']) ? $settings['newsletter_section_des'] : ''}}</textarea>
                    </div>
                </div>
                <div class="col-lg-4 mt-20">
                    <div class="single-uplode">
                        <div class="uplode-catagory">
                            <span>{{__('Section Image')}}</span>
                        </div>
                        <div class="form-group buy_coin_address_input ">
                            <div id="file-upload" class="section-p">
                                <input type="file" placeholder="0.00" name="newsletter_section_img" value=""
                                       id="file" ref="file" class="dropify"
                                       @if(isset($settings['newsletter_section_img']) && (!empty($settings['newsletter_section_img'])))  data-default-file="{{asset(path_image().$settings['newsletter_section_img'])}}" @endif />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-12 mt-20">
                <button class="button-primary theme-btn">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>
