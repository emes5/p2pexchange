<div class="header-bar">
    <div class="table-title">
        <h3>{{__('Feature Section')}}</h3>
    </div>
</div>
<div class="profile-info-form">
    <form action="{{route('updateLandingSettings')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tab" value="feature">
        <div class="row">
            <div class="col-lg-12 col-12 mt-20">
                <div class="form-group">
                    <label>{{__('Feature Section Title')}}</label>
                    <input class="form-control" type="text" name="feature_section_title" value="{{isset($settings['feature_section_title']) ? $settings['feature_section_title'] : ''}}">
                </div>
            </div>
        </div>
        <div class="uplode-img-list">
            <div class="row">
                <div class="col-lg-6 mt-20">
                    <div class="form-group">
                        <label>{{__('Feature Section Short Description')}}</label>
                        <textarea class="form-control" name="feature_section_des" id=""  rows="7">{{isset($settings['feature_section_des']) ? $settings['feature_section_des'] : ''}}</textarea>
                    </div>
                </div>
                <div class="col-lg-4 mt-20">
                    <div class="single-uplode">
                        <div class="uplode-catagory">
                            <span>{{__('Section Image')}}</span>
                        </div>
                        <div class="form-group buy_coin_address_input ">
                            <div id="file-upload" class="section-p">
                                <input type="file" placeholder="0.00" name="feature_section_img" value=""
                                       id="file" ref="file" class="dropify"
                                       @if(isset($settings['feature_section_img']) && (!empty($settings['feature_section_img'])))  data-default-file="{{asset(path_image().$settings['feature_section_img'])}}" @endif />
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
    <div class="header-bar mt-5">
        <div class="table-title">
            <h3>{{__('Add Feature ')}}</h3>
        </div>
    </div>
    @if(isset($pexer_features[0]))
        <div class="row">
            <div class="col-md-12">
                @foreach($pexer_features as $feature)
                    <div id="key_feature_prxer{{$feature->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text"  value="{{explode('|',$feature->slug)[1]}}" disabled class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <textarea disabled id="" rows="2" class="form-control">{{$feature->value}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3 text-right">
                                <div class="d-flex">
                                    <p onclick="delete_feature('{{$feature->id}}');" class="btn btn-danger px-5 mb-3 mr-3">{{__('Delete')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <form action="{{route('updatePexerFeature')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tab" value="feature">
        <div class="row">
            <div class="col-md-12">
                <div id="key_feature_wrapper">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="pexer_feature[]"  value=""
                                       class="form-control" placeholder="{{__('Feature Title')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="pexer_value[]" placeholder="{{__('Feature Description')}}" id="" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-3 text-right">
                            <div class="d-flex">
                                <p class="btn btn-primary  addKeyFeatureBtn px-5 mb-3 mr-3">{{__('Add More')}}</p>
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
