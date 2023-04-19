<div class="header-bar">
    <div class="table-title">
        <h3>{{__('Testimonial Section')}}</h3>
    </div>
</div>
<div class="profile-info-form">
    <form action="{{route('updateLandingSettings')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tab" value="testimonial">
        <div class="row">
            <div class="col-lg-12 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Testimonial Section Title')}}</label>
                    <input class="form-control" type="text" name="testimonial_section_title" value="{{isset($settings['testimonial_section_title']) ? $settings['testimonial_section_title'] : ''}}">
                </div>
            </div>
        </div>
        <div class="uplode-img-list">
            <div class="row">
                <div class="col-lg-6 mt-20">
                    <div class="form-group">
                        <label>{{__('Testimonial Section Short Description')}}</label>
                        <textarea class="form-control" name="testimonial_section_des" id=""  rows="7">{{isset($settings['testimonial_section_des']) ? $settings['testimonial_section_des'] : ''}}</textarea>
                    </div>
                </div>
                <div class="col-lg-4 mt-20">
                    <div class="single-uplode">
                        <div class="uplode-catagory">
                            <span>{{__('Section Image')}}</span>
                        </div>
                        <div class="form-group buy_coin_address_input ">
                            <div id="file-upload" class="section-p">
                                <input type="file" placeholder="0.00" name="testimonial_section_img" value=""
                                       id="file" ref="file" class="dropify"
                                       @if(isset($settings['testimonial_section_img']) && (!empty($settings['testimonial_section_img'])))  data-default-file="{{asset(path_image().$settings['testimonial_section_img'])}}" @endif />
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
