<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">section show / hide</h3>
                <label class="switch">
                    <input type="hidden" name="banner[section_id]" value="{{$section_parent->section_id}}">
                    <input type="checkbox" id="banner_status" name="banner[status]" @if($section_parent->section_status) checked @endif value="1">
                    <span class="slider round"></span>
                </label>
                @if($active_page_key!='custom_three')
                    <h3 class="sidebar-title">Filter show / hide</h3>
                    <label class="switch">
                        <input type="checkbox" id="banner_is_filter" name="banner[is_filter]" @if($section_data[0]->is_filter) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                @endif
                <h3 class="sidebar-title">{{__('Add Information')}}</h3>
                <input type="hidden" name="banner[section_detail_id]" value="{{$section_data[0]->id}}">
                <input type="hidden" name="banner[landing_page_id]" value="{{$active_page_id}}">
                <input type="hidden" id="page_key_in_banner" name="banner[page_key]" value="{{$active_page_key}}">
                <div class="form-group">
                    <label for="banner_title">{{__('Banner Title')}}</label>
                    <input type="text" class="form-control" id="banner_title" name="banner[title]" value="{{$section_data[0]->title ?? ''}}" placeholder="Enter Banner Title" />
                </div>
                <div class="form-group">
                    <label for="banner_short_description">{{__('Banner Short Description')}}</label>
                    <input type="text" class="form-control" id="banner_short_description" name="banner[short_description]" value="{{$section_data[0]->short_description ?? ''}}" placeholder="Enter Short Description" />
                </div>
                @if($active_page_key=='xyz')
                    <div class="form-group">
                        <label for="banner_long_description">{{__('Banner Long Description')}}</label>
                        <input type="text" class="form-control" id="banner_long_description" name="banner[long_description]" value="{{$section_data[0]->long_description ?? ''}}" placeholder="Enter Long Description" />
                    </div>
                @endif
                <div class="form-group">
                    <label for="banner_image">{{__('Banner Image (1920×1080)')}}</label>
                    <input type="file" class="dropify" data-default-file="{{check_storage_image_exists($section_data[0]->image)}}" id="banner_image" name="banner[image]" />
                </div>
                @if($active_page_key=='xyz')
                    <div class="form-group">
                        <label for="banner_video_link">{{__('Video Link')}}</label>
                        <input type="text" class="form-control" id="banner_video_link" name="banner[video_link]" value="{{$section_data[0]->video_link ?? ''}}" placeholder="Enter Video Link" />
                    </div>
                @endif
                @if($active_page_key=='custom_one')
                    <div class="form-group">
                        <label for="banner_login_button_name">{{__('Login Button Name')}}</label>
                        <input type="text" class="form-control" id="banner_login_button_name" name="banner[login_button_name]" value="{{$section_data[0]->login_button_name ?? ''}}" placeholder="Enter Video Link" />
                    </div>
                @endif
                @if($active_page_key!='custom_three')
                    <div class="form-group">
                        <label for="banner_register_button_name">{{__('Register Button Name')}}</label>
                        <input type="text" class="form-control" id="banner_register_button_name" name="banner[register_button_name]" value="{{$section_data[0]->register_button_name ?? ''}}" placeholder="Enter Video Link" />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function()
    {
        $(document).on('change','#banner_is_filter',function (e){
            const checked = $(this).is(':checked');
            if(checked){
                $(this).val(1);
                $('.find-offer-div').show();
            }else{
                $(this).val(0);
                $('.find-offer-div').hide();
            }
        });
        $(document).on('change','#banner_status',function (e){
            const checked = $(this).is(':checked');
            if(checked){
                $(this).val(1);
                $('.banner-section').show();
            }else{
                $(this).val(0);
                $('.banner-section').hide();
            }
        });
        $(document).on('input','#banner_title',function (e){
            const title = $(this).val();
            $('.hero-title').html(title);
        });
        $(document).on('input','#banner_short_description',function (e){
            const description = $(this).val();
            $('.hero-content').html(description);
        });
        $(document).on('input','#banner_login_button_name',function (e){
            const login_button_name = $(this).val();
            $('.login_button_name').html(login_button_name);
        });
        $(document).on('input','#banner_register_button_name',function (e){
            const register_button_name = $(this).val();
            $('.register_button_name').html(register_button_name);
        });
        $(document).on('change','#banner_image',function (e){
            var page_key = $('#page_key_in_banner').val();
            const [file] = this.files
            if(page_key=='custom_three'){
                if (file) {
                    $(".hero-banner-area").attr('src',URL.createObjectURL(file));
                }
            }else{
                if (file) {
                    var element_prefix = $('#element_prefix').val();
                    $(".hero-banner-area"+element_prefix).css("background-image", 'url(' + URL.createObjectURL(file) + ')');
                    var drEvent = $('#banner_image').dropify();
                    drEvent.on('dropify.afterClear', function(event, element) {
                        var element_prefix = $('#element_prefix').val();
                        $(".hero-banner-area"+element_prefix).css('background-image','none');
                    });
                }
            }
        });
        var page_key = $('#page_key_in_banner').val();
        var drEvent = $('#banner_image').dropify();
        drEvent.on('dropify.afterClear', function(event, element) {
            if(page_key=='custom_three'){
                $(".hero-banner-area").removeAttr('src');
            }else{
                var element_prefix = $('#element_prefix').val();
                $(".hero-banner-area"+element_prefix).css('background-image','none');
            }
            var element_prefix = $('#element_prefix').val();

        });
    });
</script>
