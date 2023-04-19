<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">Feature Info</h3>
                    <h3 class="sidebar-title">section show / hide</h3>
                    <label class="switch">
                        <input type="hidden" name="feature[section_id]" value="{{$section_parent->section_id}}">
                        <input type="hidden" name="feature[landing_page_id]" value="{{$active_page_id}}">
                        <input type="hidden" id="active_page_key_feature" name="feature[page_key]" value="{{$active_page_key}}">
                        <input type="checkbox" id="feature_status" name="feature[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <h3 class="sidebar-title">Section Title</h3>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="feature_section_title" name="feature[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                    </div>
                    <div class="form-group">
                        <label for="sub_title">Description</label>
                        <input type="text" class="form-control" id="feature_section_description" name="feature[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                    </div>
                <h3 class="sidebar-title">Feature Details</h3>
                <div class="items-list feature-details-list">
                    @foreach($section_data as $section_details)
                        <div class="sngle-item feature-details-{{$section_details->id}}">
                            <div class="item-left">
                                @if($active_page_key!='custom_three')
                                <img class="item-image" src="{{check_storage_image_exists($section_details->icon)}}" alt="btc" />
                                @endif
                                <h4 class="item-title">{{$section_details->sub_title}}</h4>
                            </div>
                            <div class="item-right">
                                <a href="#" class="edite edit_feature" data-id="{{$section_details->id}}"><i class="far fa-edit"></i></a>
                                <a href="#" class="delet delete_feature" data-id="{{$section_details->id}}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <input type="hidden" name="section_id" id="feature_section_id" value="{{$section_parent->section_id}}">
                <input type="hidden" id="landing_page_id" name="landing_page_id" value="{{$active_page_id}}">
                <input type="hidden" name="page_key" id="feature_page_key" value="{{$active_page_key}}">
                <input type="hidden" name="id" id="detail_id_feature" value="">
                <div class="item-group">
                    <input type="hidden" name="serial" id="serial_feature" value="{{getLastSerialOfFeature('feature',$active_page_id)+1}}">
                    @if($active_page_key!='custom_three')
                        <div class="form-group">
                            <label for="coin_image">Icon (70*70)</label>
                            <input type="file" name="icon" class="dropify" id="icon_feature" />
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="sub_title">Sub Title</label>
                        <input type="text" class="form-control" id="sub_title_feature" name="sub_title" value="" placeholder="Enter Sub Title" />
                    </div>
                    <div class="form-group">
                        <label for="sub_description">Sub Description</label>
                        <textarea class="form-control textarea" name="sub_description" id="sub_description_feature" cols="30" rows="10" placeholder="Enter Sub Descripton"></textarea>
                    </div>
                </div>
                <button type="button" class="add-btn submit_feature_details">{{__('Add More')}}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click','.submit_feature_details',function (e){
        e.preventDefault();
        var landing_page_id = $('#landing_page_id').val();
        var id = $('#detail_id_feature').val();
        var url = "{{route('saveFeatureDetails')}}";
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('section_id', $('#feature_section_id').val());
        formData.append('landing_page_id', landing_page_id);
        formData.append('page_key', $('#feature_page_key').val());
        formData.append('id', id);
        formData.append('serial', $('#serial_feature').val());
        formData.append('sub_title', $('#sub_title_feature').val());
        formData.append('sub_description', $('#sub_description_feature').val());
        var page_key = $('#active_page_key_feature').val();
        if(page_key!='custom_three'){
            if(typeof $('#icon_feature')[0].files[0] !== 'undefined'){
                formData.append('icon', $('#icon_feature')[0].files[0]);
            }
        }
        makeAjaxPostFile(formData, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_feature').val(response.data.new_serial);
                if(page_key!='custom_three'){
                    var drEvent = $('#icon_feature').dropify();
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                }
                $('#detail_id_feature').val('');
                $('#sub_title_feature').val('');
                $('#sub_description_feature').val('');
                $('.submit_feature_details').html('Add More');
                var exist = $("div").hasClass('feature-details-'+response.data.id);
                var html = '<div class="sngle-item feature-details-'+response.data.id+'">';
                var image_con = '';
                if(page_key!='custom_three'){
                    image_con = '<img class="item-image" src="'+response.data.icon+'" alt="'+response.data.sub_title+'" />';
                }
                var body_html = '<div class="item-left">'+
                    image_con+
                    '<h4 class="item-title">'+response.data.sub_title+'</h4></div>'+
                    '<div class="item-right"><a href="#" class="edite edit_feature" data-id="'+response.data.id+'"><i class="far fa-edit"></i></a>'+
                    '<a href="#" class="delet delete_feature" data-id="'+response.data.id+'"><i class="fas fa-trash"></i></a></div>';
                var footer_html = '</div>';
                if(exist){
                    $('.feature-details-'+response.data.id).html(body_html);
                }
                else{
                    $('.feature-details-list').append(html+body_html+footer_html);
                }
                if(page_key=='custom_three'){
                    var detail_html_head = `<div class="col-lg-6 col-md-6 col-12 mb-5 wow animate__fadeInLeft feature-details-view-${response.data.id}" data-wow-duration="500ms">`;
                    var detail_html_body = `<div class="single-feature text-center">
                            <h3 class="feature-title">${response.data.sub_title}</h3>
                            <p class="feature-content">${response.data.sub_description}</p>
                    </div>`;
                    var detail_html_footer = `</div>`;
                    if(id){
                        $('.feature-details-view-'+response.data.id).html(detail_html_body);
                    }
                    else{
                        $('.feature-details-container').append(detail_html_head+detail_html_body+detail_html_footer);
                    }
                }else{
                    var detail_html_head = `<div class="col-lg-4 col-md-6 feature-details-view-${response.data.id}">`;
                    var detail_html_body = `<div class="single-feature text-center">
                        <img class="feature-icon" src="${response.data.icon}" alt="">
                            <h4 class="feature-title">${response.data.sub_title}</h4>
                            <p class="feature-content">${response.data.sub_description}</p>
                    </div>`;
                    var detail_html_footer = `</div>`;
                    if(id){
                        $('.feature-details-view-'+response.data.id).html(detail_html_body);
                    }
                    else{
                        $('.feature-details-container').append(detail_html_head+detail_html_body+detail_html_footer);
                    }
                }
                swalSuccess(response.message);
            }
        });
    });
    $(document).on('change','#feature_status',function (e){
        const checked = $(this).is(':checked');
        if(checked){
            $(this).val(1);
            $('.feature-section').show();
        }else{
            $(this).val(0);
            $('.feature-section').hide();
        }
    });
    $(document).on('input','#feature_section_title',function (e){
        const title = $(this).val();
        $('.feature_title').html(title);
    });
    $(document).on('input','#feature_section_description',function (e){
        const description = $(this).val();
        $('.feature_sub_title').html(description);
    });
    $(document).on('click','.edit_feature',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{route('getFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'id' : id,
            'type':'feature'
        };
        makeAjaxPost(data, url).done(function (response) {
            $('#serial_feature').val(response.detail.serial);
            $('#detail_id_feature').val(response.detail.id);
            $('#sub_title_feature').val(response.detail.sub_title);
            $('#sub_description_feature').val(response.detail.sub_description);
            var page_key = $('#active_page_key_feature').val();
            if(page_key!='custom_three') {
                var imagenUrl = response.detail.icon;
                var drEvent = $('#icon_feature').dropify(
                    {
                        defaultFile: imagenUrl
                    });
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                drEvent.settings.defaultFile = imagenUrl;
                drEvent.destroy();
                drEvent.init();
            }
            $('.submit_feature_details').html('Save');
        });
    });
    $(document).on('click','.delete_feature',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var landing_page_id = $('#landing_page_id').val();
        var url = "{{route('deleteFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'type': 'feature',
            id : id,
            landing_page_id:landing_page_id
        };
        makeAjaxPost(data, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_feature').val(response.new_serial);
                $('#detail_id_feature').val('');
                var page_key = $('#active_page_key_feature').val();
                if(page_key!='custom_three') {
                    var drEvent = $('#icon_feature').dropify();
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                }
                $('#sub_title_feature').val('');
                $('#sub_description_feature').val('');
                $('.submit_feature_details').html('Add More');
                $('.feature-details-view-'+id).remove();
                $('.feature-details-'+id).remove();
                swalSuccess(response.message);
            }
        });
    });
</script>
