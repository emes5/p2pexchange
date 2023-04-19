<div class="header-bar">
    <div class="table-title">
        <h3>{{__('Trade Process Settings')}}</h3>
    </div>
</div>
<div class="profile-info-form">
    <form action="{{route('updateLandingSettings')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tab" value="trade">
        <div class="row">
            <div class="col-lg-6 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Trade Section Title')}}</label>
                    <input class="form-control" type="text" name="trade_section_title" value="{{isset($settings['trade_section_title']) ? $settings['trade_section_title'] : ''}}">
                </div>
            </div>
            <div class="col-lg-6 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Trade Section Short Description')}}</label>
                    <textarea class="form-control" name="trade_section_des" id=""  rows="2">{{isset($settings['trade_section_des']) ? $settings['trade_section_des'] : ''}}</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Trading Process Step One Title')}}</label>
                    <input class="form-control" type="text" name="trade_process_one_title" value="{{isset($settings['trade_process_one_title']) ? $settings['trade_process_one_title'] : ''}}">
                </div>
                <div class="form-group">
                    <label>{{__('Trading Process Step One Description')}}</label>
                    <textarea class="form-control" name="trade_process_one_des" id=""  rows="2">{{isset($settings['trade_process_one_des']) ? $settings['trade_process_one_des'] : ''}}</textarea>
                </div>
            </div>
            <div class="col-lg-4 mt-20">
                <div class="single-uplode">
                    <div class="uplode-catagory">
                        <span>{{__('Step One Image')}}</span>
                    </div>
                    <div class="form-group buy_coin_address_input ">
                        <div id="file-upload" class="section-p">
                            <input type="file" placeholder="0.00" name="trade_process_one_img" value=""
                                   id="file" ref="file" class="dropify"
                                   @if(isset($settings['trade_process_one_img']) && (!empty($settings['trade_process_one_img'])))  data-default-file="{{asset(path_image().$settings['trade_process_one_img'])}}" @endif />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Trading Process Step Two Title')}}</label>
                    <input class="form-control" type="text" name="trade_process_two_title" value="{{isset($settings['trade_process_two_title']) ? $settings['trade_process_two_title'] : ''}}">
                </div>
                <div class="form-group">
                    <label>{{__('Trading Process Step Two Description')}}</label>
                    <textarea class="form-control" name="trade_process_two_des" id=""  rows="2">{{isset($settings['trade_process_two_des']) ? $settings['trade_process_two_des'] : ''}}</textarea>
                </div>
            </div>
            <div class="col-lg-4 mt-20">
                <div class="single-uplode">
                    <div class="uplode-catagory">
                        <span>{{__('Step Two Image')}}</span>
                    </div>
                    <div class="form-group buy_coin_address_input ">
                        <div id="file-upload" class="section-p">
                            <input type="file" placeholder="0.00" name="trade_process_two_img" value=""
                                   id="file" ref="file" class="dropify"
                                   @if(isset($settings['trade_process_two_img']) && (!empty($settings['trade_process_two_img'])))  data-default-file="{{asset(path_image().$settings['trade_process_two_img'])}}" @endif />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Trading Process Step Three Title')}}</label>
                    <input class="form-control" type="text" name="trade_process_three_title" value="{{isset($settings['trade_process_three_title']) ? $settings['trade_process_three_title'] : ''}}">
                </div>
                <div class="form-group">
                    <label>{{__('Trading Process Step Three Description')}}</label>
                    <textarea class="form-control" name="trade_process_three_des" id=""  rows="2">{{isset($settings['trade_process_three_des']) ? $settings['trade_process_three_des'] : ''}}</textarea>
                </div>
            </div>
            <div class="col-lg-4 mt-20">
                <div class="single-uplode">
                    <div class="uplode-catagory">
                        <span>{{__('Step Three Image')}}</span>
                    </div>
                    <div class="form-group buy_coin_address_input ">
                        <div id="file-upload" class="section-p">
                            <input type="file" placeholder="0.00" name="trade_process_three_img" value=""
                                   id="file" ref="file" class="dropify"
                                   @if(isset($settings['trade_process_three_img']) && (!empty($settings['trade_process_three_img'])))  data-default-file="{{asset(path_image().$settings['trade_process_three_img'])}}" @endif />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Trading Process Step Four Title')}}</label>
                    <input class="form-control" type="text" name="trade_process_four_title" value="{{isset($settings['trade_process_four_title']) ? $settings['trade_process_four_title'] : ''}}">
                </div>
                <div class="form-group">
                    <label>{{__('Trading Process Step Four Description')}}</label>
                    <textarea class="form-control" name="trade_process_four_des" id=""  rows="2">{{isset($settings['trade_process_four_des']) ? $settings['trade_process_four_des'] : ''}}</textarea>
                </div>
            </div>
            <div class="col-lg-4 mt-20">
                <div class="single-uplode">
                    <div class="uplode-catagory">
                        <span>{{__('Step Four Image')}}</span>
                    </div>
                    <div class="form-group buy_coin_address_input ">
                        <div id="file-upload" class="section-p">
                            <input type="file" placeholder="0.00" name="trade_process_four_img" value=""
                                   id="file" ref="file" class="dropify"
                                   @if(isset($settings['trade_process_four_img']) && (!empty($settings['trade_process_four_img'])))  data-default-file="{{asset(path_image().$settings['trade_process_four_img'])}}" @endif />
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
