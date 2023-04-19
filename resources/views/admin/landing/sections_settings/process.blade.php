<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">Process Info</h3>
                    <h3 class="sidebar-title">section show / hide</h3>
                    <label class="switch">
                        <input type="hidden" name="process[section_id]" value="{{$section_parent->section_id}}">
                        <input type="hidden" name="process[landing_page_id]" value="{{$active_page_id}}">
                        <input type="hidden" name="process[page_key]" value="{{$active_page_key}}">
                        <input type="checkbox" id="status_process" name="process[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <h3 class="sidebar-title">Section Title</h3>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="section_title_process" name="process[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                    </div>
                    <div class="form-group">
                        <label for="sub_title">Description</label>
                        <input type="text" class="form-control" id="section_description_process" name="process[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                    </div>
                <h3 class="sidebar-title">Process Details</h3>
                <div class="items-list process-details-list">
                    @foreach($section_data as $section_details)
                        <div class="sngle-item process-details-{{$section_details->id}}">
                            <div class="item-left">
                                <img class="item-image" src="{{check_storage_image_exists($section_details->image)}}" alt="btc" />
                                <h4 class="item-title">{{$section_details->serial.'. '.$section_details->sub_title}}</h4>
                            </div>
                            <div class="item-right">
                                <a href="#" class="edite edit_process" data-id="{{$section_details->id}}"><i class="far fa-edit"></i></a>
                                @if($active_page_key != 'custom_three')
                                    <a href="#" class="delet delete_process" data-id="{{$section_details->id}}"><i class="fas fa-trash"></i></a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <input type="hidden" name="section_id" id="process_section_id" value="{{$section_parent->section_id}}">
                <input type="hidden" id="landing_page_id" name="landing_page_id" value="{{$active_page_id}}">
                <input type="hidden" name="page_key" id="process_page_key" value="{{$active_page_key}}">
                <input type="hidden" name="id" id="detail_id_process" value="">
                <div class="item-group editable-form" @if($active_page_key == 'custom_three') style="display: none" @endif>
                    <input type="hidden" name="serial" id="serial_process" value="{{getLastSerialOfFeature('process',$active_page_id)+1}}">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="dropify" id="image_process" />
                    </div>
                    <div class="form-group">
                        <label for="sub_title">Sub Title</label>
                        <input type="text" class="form-control" id="sub_title_process" name="sub_title" value="" placeholder="Enter Sub Title" />
                    </div>
                    <div class="form-group">
                        <label for="sub_description">Sub Description</label>
                        <textarea class="form-control textarea" name="sub_description" id="sub_description_process" cols="30" rows="10" placeholder="Enter Sub Descripton"></textarea>
                    </div>
                </div>
                <button type="submit" class="add-btn submit_process_details" @if($active_page_key == 'custom_three') style="display: none" @endif>
                    @if($active_page_key != 'custom_three') {{__('Add More')}} @else {{__('Save')}}  @endif
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).on('click','.submit_process_details',function (e){
        e.preventDefault();
        var landing_page_id = $('#landing_page_id').val();
        var id = $('#detail_id_process').val();
        var url = "{{route('saveProcessDetails')}}";
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('section_id', $('#process_section_id').val());
        formData.append('landing_page_id', landing_page_id);
        formData.append('page_key', $('#process_page_key').val());
        formData.append('id', id);
        formData.append('serial', $('#serial_process').val());
        formData.append('sub_title', $('#sub_title_process').val());
        formData.append('sub_description', $('#sub_description_process').val());
        if(typeof $('#image_process')[0].files[0] !== 'undefined'){
            formData.append('image', $('#image_process')[0].files[0]);
        }
        makeAjaxPostFile(formData, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                var page_key = $('#process_page_key').val();
                var drEvent = $('#image_process').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#serial_process').val(response.data.new_serial);
                $('#detail_id_process').val('');
                $('#sub_title_process').val('');
                $('#sub_description_process').val('');
                var exist = $("div").hasClass('process-details-'+response.data.id);
                var html = '<div class="sngle-item process-details-'+response.data.id+'">';
                var body_html = '<div class="item-left">'+
                    '<img class="item-image" src="'+response.data.image+'" alt="'+response.data.sub_title+'" />'+
                    '<h4 class="item-title">'+response.data.serial+'.'+response.data.sub_title+'</h4></div>'+
                    '<div class="item-right"><a href="#" class="edite edit_process" data-id="'+response.data.id+'"><i class="far fa-edit"></i></a>';
                if(page_key!='custom_three') {
                    body_html += '<a href="#" class="delet delete_process" data-id="' + response.data.id + '"><i class="fas fa-trash"></i></a></div>';
                }
                var footer_html = '</div>';
                if(exist){
                    $('.process-details-'+response.data.id).html(body_html);
                }
                else{
                    $('.process-details-list').append(html+body_html+footer_html);
                }
                if(page_key=='custom_three'){
                    $('.editable-form').hide();
                    $('.submit_process_details').hide();
                    $('.image-process-'+response.data.serial).attr('src',response.data.image);
                    $('.sub-title-process-'+response.data.serial).html(response.data.serial+'.'+response.data.sub_title);
                    $('.sub-description-process-'+response.data.serial).html(response.data.sub_description);
                }else{
                    $('.submit_process_details').html('Add More');
                    var detail_html_head = `<div class="col-lg-4 col-md-6 process-details-view-${response.data.id}">`;
                    var detail_html_body = `<div class="single-process">
                        <span class="process-count">${response.data.serial}</span>
                        <img class="process-icon" src="${response.data.image}" alt="work-icon">
                            <h3 class="process-title">${response.data.sub_title}</h3>
                            <p class="process-content">${response.data.sub_description}</p>
                    </div>`;
                    var detail_html_footer = `</div>`;
                    if(id){
                        $('.process-details-view-'+response.data.id).html(detail_html_body);
                    }
                    else{
                        $('.process-details-container').append(detail_html_head+detail_html_body+detail_html_footer);
                    }
                }
                swalSuccess(response.message);
            }
        });
    });
    $(document).on('change','#status_process',function (e){
        const checked = $(this).is(':checked');
        if(checked){
            $(this).val(1);
            $('.process-section').show();
        }else{
            $(this).val(0);
            $('.process-section').hide();
        }
    });
    $(document).on('input','#section_title_process',function (e){
        const title = $(this).val();
        $('.section-title-process-main').html(title);
    });
    $(document).on('input','#section_description_process',function (e){
        const description = $(this).val();
        $('.section-subtitle-process-main').html(description);
    });
    $(document).on('click','.edit_process',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{route('getFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'id' : id,
            'type':'process'
        };
        makeAjaxPost(data, url).done(function (response) {
            $('.editable-form').show();
            $('.submit_process_details').show();
            var imagenUrl = response.detail.image;
            var drEvent = $('#image_process').dropify(
                {
                    defaultFile: imagenUrl
                });
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();
            drEvent.settings.defaultFile = imagenUrl;
            drEvent.destroy();
            drEvent.init();
            $('#serial_process').val(response.detail.serial);
            $('#detail_id_process').val(response.detail.id);
            $('#sub_title_process').val(response.detail.sub_title);
            $('#sub_description_process').val(response.detail.sub_description);
            $('.submit_process_details').html('Save');
        });
    });
    $(document).on('click','.delete_process',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var landing_page_id = $('#landing_page_id').val();
        var url = "{{route('deleteFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'type': 'process',
            id : id,
            landing_page_id:landing_page_id
        };
        makeAjaxPost(data, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_process').val(response.new_serial);
                $('#detail_id_process').val('');
                var drEvent = $('#image_process').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#sub_title_process').val('');
                $('#sub_description_process').val('');
                $('.submit_process_details').html('Add More');
                $('.process-details-view-'+id).remove();
                $('.process-details-'+id).remove();
                swalSuccess(response.message);
            }
        });
    });

</script>

