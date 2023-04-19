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
                    <input type="hidden" name="about[section_id]" value="{{$section_parent->section_id}}">
                    <input type="checkbox" id="about_status" name="about[status]" @if($section_parent->section_status) checked @endif value="1">
                    <span class="slider round"></span>
                </label>
                <h3 class="sidebar-title">{{__('Add Information')}}</h3>
                <input type="hidden" name="about[section_detail_id]" value="{{$section_data[0]->id}}">
                <input type="hidden" name="about[landing_page_id]" value="{{$active_page_id}}">
                <input type="hidden" name="about[page_key]" value="{{$active_page_key}}">
                <div class="form-group">
                    <label for="about_title">{{__('About Title')}}</label>
                    <input type="text" class="form-control" id="about_title" name="about[title]" value="{{$section_data[0]->title ?? ''}}" placeholder="Enter Banner Title" />
                </div>
                <div class="form-group">
                    <label for="about_short_description">{{__('About Short Description')}}</label>
                    <input type="text" class="form-control" id="about_short_description" name="about[short_description]" value="{{$section_data[0]->short_description ?? ''}}" placeholder="Enter Short Description" />
                </div>
                <div class="form-group">
                    <label for="about_long_description">{{__('About Long Description')}}</label>
                    <input type="text" class="form-control" id="about_long_description" name="about[long_description]" value="{{$section_data[0]->long_description ?? ''}}" placeholder="Enter Long Description" />
                </div>
                <div class="form-group">
                    <label for="about_image">{{__('About Image (645×718)')}}</label>
                    <input type="file" class="dropify" data-default-file="{{check_storage_image_exists($section_data[0]->image)}}" id="about_image" name="about[image]" />
                </div>
                @if($active_page_key=='xyz')
                    <div class="form-group">
                        <label for="about_video_link">{{__('Video Link')}}</label>
                        <input type="text" class="form-control" id="about_video_link" name="about[video_link]" value="{{$section_data[0]->video_link ?? ''}}" placeholder="Enter Video Link" />
                    </div>
                @endif
                <div class="form-group">
                    <label for="about_button_name">{{__('Button Name')}}</label>
                    <input type="text" class="form-control" id="about_button_name" name="about[button_name]" value="{{$section_data[0]->button_name ?? ''}}" placeholder="Enter Button Name" />
                </div>
                <div class="form-group">
                    <label for="about_button_link">{{__('Button link')}}</label>
                    <input type="text" class="form-control" id="about_button_link" name="about[button_link]" value="{{$section_data[0]->button_link ?? ''}}" placeholder="Enter Button Link" />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function()
    {
        $(document).on('change','#about_status',function (e){
            const checked = $(this).is(':checked');
            if(checked){
                $(this).val(1);
                $('.about-section').show();
            }else{
                $(this).val(0);
                $('.about-section').hide();
            }
        });
        $(document).on('input','#about_title',function (e){
            const title = $(this).val();
            $('.about-title').html(title);
        });
        $(document).on('input','#about_short_description',function (e){
            const description = $(this).val();
            $('.about-subtitle').html(description);
        });
        $(document).on('input','#about_long_description',function (e){
            const description = $(this).val();
            $('.about-long-subtitle').html(description);
        });
        $(document).on('input','#about_button_name',function (e){
            const button_name = $(this).val();
            $('.about-button-name').html(button_name);
        });
        $(document).on('input','#about_button_link',function (e){
            const button_link = $(this).val();
            $('.about-button-name').attr('href',button_link);
        });
        $(document).on('change','#about_image',function (e){
            const [file] = this.files
            if (file) {
                var element_prefix = $('#element_prefix').val();
                $(".about-image"+element_prefix).children('img').attr('src',URL.createObjectURL(file));
            }
        });
        var drEvent = $('#about_image').dropify();
        drEvent.on('dropify.afterClear', function(event, element) {
            var element_prefix = $('#element_prefix').val();
            $(".about-image"+element_prefix).children('img').attr('src','');
        });
    });
</script>
