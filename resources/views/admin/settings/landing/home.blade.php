<div class="header-bar">
    <div class="table-title">
        <h3>{{__('Home Section')}}</h3>
    </div>
</div>
<div class="profile-info-form">
    <form action="{{route('updateLandingSettings')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tab" value="home">
        <div class="row">
            <div class="col-lg-6 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Landing Banner Title')}}</label>
                    <input class="form-control" type="text" name="landing_banner_title"
                           placeholder="{{__('Landing Banner Title')}}" value="{{isset($settings['landing_banner_title']) ? $settings['landing_banner_title'] : ''}}">
                </div>
            </div>
            <div class="col-lg-6 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Landing Banner Sub Title')}}</label>
                    <input class="form-control" type="text" name="landing_banner_sub_title"
                           placeholder="{{__('Landing Banner Sub Title')}}" value="{{isset($settings['landing_banner_sub_title']) ? $settings['landing_banner_sub_title'] : ''}}">
                </div>
            </div>
        </div>
        <div class="uplode-img-list">
            <div class="row">
                <div class="col-lg-6 mt-20">
                    <div class="form-group">
                        <label>{{__('Landing Banner Short Description')}}</label>
                        <textarea class="form-control" name="landing_banner_description" id=""  rows="7">{{isset($settings['landing_banner_description']) ? $settings['landing_banner_description'] : ''}}</textarea>
                    </div>
                </div>
                <div class="col-lg-4 mt-20">
                    <div class="single-uplode">
                        <div class="uplode-catagory">
                            <span>{{__('Banner Image')}}</span>
                        </div>
                        <div class="form-group buy_coin_address_input ">
                            <div id="file-upload" class="section-p">
                                <input type="file" placeholder="0.00" name="landing_banner_img" value=""
                                       id="file" ref="file" class="dropify"
                                       @if(isset($settings['landing_banner_img']) && (!empty($settings['landing_banner_img'])))  data-default-file="{{asset(path_image().$settings['landing_banner_img'])}}" @endif />
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
