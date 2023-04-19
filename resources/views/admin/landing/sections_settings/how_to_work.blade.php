<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">How work Info</h3>
                    <h3 class="sidebar-title">section show / hide</h3>
                    <label class="switch">
                        <input type="hidden" name="how_to_work[section_id]" value="{{$section_parent->section_id}}">
                        <input type="hidden" name="how_to_work[landing_page_id]" value="{{$active_page_id}}">
                        <input type="hidden" name="how_to_work[page_key]" value="{{$active_page_key}}">
                        <input type="checkbox" id="work_status" name="how_to_work[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <h3 class="sidebar-title">Section Title</h3>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="work_section_title" name="how_to_work[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                    </div>
                    <div class="form-group">
                        <label for="sub_title">Description</label>
                        <input type="text" class="form-control" id="work_section_description" name="how_to_work[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                    </div>
                <h3 class="sidebar-title">How Work Details</h3>
                <div class="items-list work-details-list">
                    @foreach($section_data as $section_details)
                        <div class="sngle-item work-details-{{$section_details->id}}">
                            <div class="item-left">
                                <img class="item-image" src="{{check_storage_image_exists($section_details->image)}}" alt="btc" />
                                <h4 class="item-title">{{$section_details->sub_title}}</h4>
                            </div>
                            <div class="item-right">
                                <a href="#" class="edite edit_work" data-id="{{$section_details->id}}"><i class="far fa-edit"></i></a>
                                <a href="#" class="delet delete_work" data-id="{{$section_details->id}}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                    <input type="hidden" name="section_id" id="work_section_id" value="{{$section_parent->section_id}}">
                    <input type="hidden" id="landing_page_id" name="landing_page_id" value="{{$active_page_id}}">
                    <input type="hidden" name="page_key"  id="work_page_key" value="{{$active_page_key}}">
                    <input type="hidden" name="id" id="detail_id_work" value="">
                    <div class="item-group">
                        <input type="hidden" name="serial" id="serial_work" value="{{getLastSerialOfFeature('work',$active_page_id)+1}}">

                        <div class="form-group">
                            <label for="image">Select Type</label>
                            <select name="type" id="type_work" class="form-control">
                                <option value="">Select Type</option>
                                <option value="1">Buy</option>
                                <option value="2">Sell</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="dropify" id="image_work" />
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title</label>
                            <input type="text" class="form-control" id="sub_title_work" name="sub_title" value="" placeholder="Enter Sub Title" />
                        </div>
                        <div class="form-group">
                            <label for="sub_description">Sub Description</label>
                            <textarea class="form-control textarea" name="sub_description" id="sub_description_work" cols="30" rows="10" placeholder="Enter Sub Descripton"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="add-btn submit_work_details">{{__('Add More')}}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).on('click','.submit_work_details',function (e){
        e.preventDefault();
        var landing_page_id = $('#landing_page_id').val();
        var id = $('#detail_id_work').val();
        var url = "{{route('saveWorkDetails')}}";
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('section_id', $('#work_section_id').val());
        formData.append('landing_page_id', landing_page_id);
        formData.append('page_key', $('#work_page_key').val());
        formData.append('id', id);
        formData.append('serial', $('#serial_work').val());
        formData.append('type', $('#type_work').val());
        formData.append('sub_title', $('#sub_title_work').val());
        formData.append('sub_description', $('#sub_description_work').val());
        if(typeof $('#image_work')[0].files[0] !== 'undefined'){
            formData.append('image', $('#image_work')[0].files[0]);
        }
        makeAjaxPostFile(formData, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_work').val(response.data.new_serial);
                var drEvent = $('#image_work').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#detail_id_work').val('');
                $('#type_work').val('');
                $('#sub_title_work').val('');
                $('#sub_description_work').val('');
                $('.submit_work_details').html('Add More');
                var exist = $("div").hasClass('work-details-'+response.data.id);
                var html = '<div class="sngle-item work-details-'+response.data.id+'">';
                var body_html = '<div class="item-left">'+
                    '<img class="item-image" src="'+response.data.image+'" alt="'+response.data.sub_title+'" />'+
                    '<h4 class="item-title">'+response.data.sub_title+'</h4></div>'+
                    '<div class="item-right"><a href="#" class="edite edit_work" data-id="'+response.data.id+'"><i class="far fa-edit"></i></a>'+
                    '<a href="#" class="delet delete_work" data-id="'+response.data.id+'"><i class="fas fa-trash"></i></a></div>';
                var footer_html = '</div>';
                if(exist){
                    $('.work-details-'+response.data.id).html(body_html);
                }
                else{
                    $('.work-details-list').append(html+body_html+footer_html);
                }
                var type = '';
                if(response.data.type==1){
                    type='buy';
                }else{
                    type='sell';
                }
                var detail_html_head = `<div class="col-lg-4 col-md-6 work-details-view-${response.data.id}">`;
                var detail_html_body = `<div class="single-work">
                        <img class="work-icon" src="${response.data.image}" alt="work-icon">
                            <h4 class="work-title">${response.data.sub_title}</h4>
                            <p class="work-content">${response.data.sub_description}</p>
                    </div>`;
                var detail_html_footer = `</div>`;
                if(id){
                    $('.work-details-view-'+response.data.id).html(detail_html_body);
                }
                else{
                    $('.work-details-container-'+type).append(detail_html_head+detail_html_body+detail_html_footer);
                }
                swalSuccess(response.message);
            }
        });
    });
    $(document).on('change','#work_status',function (e){
        const checked = $(this).is(':checked');
        if(checked){
            $(this).val(1);
            $('.how_to_work-section').show();
        }else{
            $(this).val(0);
            $('.how_to_work-section').hide();
        }
    });
    $(document).on('input','#work_section_title',function (e){
        const title = $(this).val();
        $('.work-title-main').html(title);
    });
    $(document).on('input','#work_section_description',function (e){
        const description = $(this).val();
        $('.work-sub-title-main').html(description);
    });
    $(document).on('click','.edit_work',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{route('getFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'id' : id,
            'type':'work'
        };
        makeAjaxPost(data, url).done(function (response) {
            var imagenUrl = response.detail.image;
            var drEvent = $('#image_work').dropify(
                {
                    defaultFile: imagenUrl
                });
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();
            drEvent.settings.defaultFile = imagenUrl;
            drEvent.destroy();
            drEvent.init();
            $('#serial_work').val(response.detail.serial);
            $('#detail_id_work').val(response.detail.id);
            $('#type_work').val(response.detail.type);
            $('#sub_title_work').val(response.detail.sub_title);
            $('#sub_description_work').val(response.detail.sub_description);
            $('.submit_work_details').html('Save');
        });
    });
    $(document).on('click','.delete_work',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var landing_page_id = $('#landing_page_id').val();
        var url = "{{route('deleteFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'type': 'work',
            id : id,
            landing_page_id:landing_page_id
        };
        makeAjaxPost(data, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_work').val(response.new_serial);
                $('#detail_id_work').val('');
                $('#type_work').val('');
                var drEvent = $('#image_work').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#sub_title_work').val('');
                $('#sub_description_work').val('');
                $('.submit_work_details').html('Add More');
                $('.work-details-view-'+id).remove();
                $('.work-details-'+id).remove();
                swalSuccess(response.message);
            }
        });
    });


</script>
