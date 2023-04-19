<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">Advantage/Crypto Info</h3>
                    <h3 class="sidebar-title">section show / hide</h3>
                    <label class="switch">
                        <input type="hidden" name="advantage[section_id]" value="{{$section_parent->section_id}}">
                        <input type="hidden" name="advantage[landing_page_id]" value="{{$active_page_id}}">
                        <input type="hidden" name="advantage[page_key]" value="{{$active_page_key}}">
                        <input type="checkbox" id="advantage_status" name="advantage[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <h3 class="sidebar-title">Section Title</h3>
                    <div class="form-group">
                        <label for="advantage_section_title">Title</label>
                        <input type="text" class="form-control" id="advantage_section_title" name="advantage[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                    </div>
                    <div class="form-group">
                        <label for="advantage_section_description">Description</label>
                        <input type="text" class="form-control" id="advantage_section_description" name="advantage[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                    </div>
                <h3 class="sidebar-title">Advantage/Crypto Details</h3>
                <div class="items-list advantage-details-list">
                    @foreach($section_data as $section_details)
                        <div class="sngle-item advantage-details-{{$section_details->id}}">
                            <div class="item-left">
                                <img class="item-image" src="{{check_storage_image_exists($section_details->image)}}" alt="btc" />
                                <h4 class="item-title">{{$section_details->sub_title}}</h4>
                            </div>
                            <div class="item-right">
                                <a href="#" class="edite edit_advantage" data-id="{{$section_details->id}}"><i class="far fa-edit"></i></a>
                                <a href="#" class="delet delete_advantage" data-id="{{$section_details->id}}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <input type="hidden" id="advantage_section_id" name="section_id" value="{{$section_parent->section_id}}">
                <input type="hidden" id="landing_page_id" name="landing_page_id" value="{{$active_page_id}}">
                <input type="hidden" id="advantage_page_key" name="page_key" value="{{$active_page_key}}">
                <input type="hidden" name="id" id="detail_id_advantage" value="">
                <div class="item-group">
                    <input type="hidden" name="serial" id="serial_advantage" value="{{getLastSerialOfFeature('advantage',$active_page_id)+1}}">
                    <div class="form-group">
                        <label for="image_advantage">Image</label>
                        <input type="file" name="image" class="dropify" data-default-file="" id="image_advantage" />
                    </div>
                    <div class="form-group">
                        <label for="sub_title_advantage">Sub Title</label>
                        <input type="text" class="form-control" id="sub_title_advantage" name="sub_title" value="" placeholder="Enter Sub Title" />
                    </div>
                    <div class="form-group">
                        <label for="sub_description_advantage">Sub Description</label>
                        <textarea class="form-control textarea" name="sub_description" id="sub_description_advantage" cols="30" rows="10" placeholder="Enter Sub Descripton"></textarea>
                    </div>
                </div>
                <button type="button" class="add-btn submit_advantage_details">{{__('Add More')}}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.submit_advantage_details',function (e){
        e.preventDefault();
        var landing_page_id = $('#landing_page_id').val();
        var id = $('#detail_id_advantage').val();
        var url = "{{route('saveAdvantageDetails')}}";
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('section_id', $('#advantage_section_id').val());
        formData.append('landing_page_id', landing_page_id);
        formData.append('page_key', $('#advantage_page_key').val());
        formData.append('id', id);
        formData.append('serial', $('#serial_advantage').val());
        formData.append('sub_title', $('#sub_title_advantage').val());
        formData.append('sub_description', $('#sub_description_advantage').val());
        if(typeof $('#image_advantage')[0].files[0] !== 'undefined'){
            formData.append('image', $('#image_advantage')[0].files[0]);
        }
        var load = $(this).ladda();
        makeAjaxPostFile(formData, url, load).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_advantage').val(response.data.new_serial);
                var drEvent = $('#image_advantage').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#detail_id_advantage').val('');
                $('.submit_advantage_details').html('Add More');
                $('#sub_title_advantage').val('');
                $('#sub_description_advantage').val('');
                var exist = $("div").hasClass('advantage-details-'+response.data.id);
                var html = '<div class="sngle-item advantage-details-'+response.data.id+'">';
                var body_html = '<div class="item-left">'+
                    '<img class="item-image" src="'+response.data.image+'" alt="'+response.data.sub_title+'" />'+
                    '<h4 class="item-title">'+response.data.sub_title+'</h4></div>'+
                    '<div class="item-right"><a href="#" class="edite edit_advantage" data-id="'+response.data.id+'"><i class="far fa-edit"></i></a>'+
                    '<a href="#" class="delet delete_advantage" data-id="'+response.data.id+'"><i class="fas fa-trash"></i></a></div>';
                var footer_html = '</div>';
                if(exist){
                    $('.advantage-details-'+response.data.id).html(body_html);
                }
                else{
                    $('.advantage-details-list').append(html+body_html+footer_html);
                }
                var detail_html_head = '<div class="col-lg-3 col-md-6 advantage-details-view-'+response.data.id+'">';
                var detail_html_body = '<div class="single-card text-center">'+
                                        '<div class="card-icon">'+
                                            '<img src="'+response.data.image+'">'+
                                        '</div>'+
                                        '<h3 class="card-title">'+response.data.sub_title+'</h3>'+
                                        '<p class="card-content">'+response.data.sub_description+'</p>'+
                                    '</div>';
                var detail_html_footer = '</div>';
                if(id){
                    $('.advantage-details-view-'+response.data.id).html(detail_html_body);
                }
                else{
                    $('.advantage-details-container').append(detail_html_head+detail_html_body+detail_html_footer);
                }
                swalSuccess(response.message);
            }
        });
    });
    $(document).on('change','#advantage_status',function (e){
        const checked = $(this).is(':checked');
        if(checked){
            $(this).val(1);
            $('.advantage-section').show();
        }else{
            $(this).val(0);
            $('.advantage-section').hide();
        }
    });
    $(document).on('input','#advantage_section_title',function (e){
        const title = $(this).val();
        $('.advantage-title').html(title);
    });
    $(document).on('input','#advantage_section_description',function (e){
        const description = $(this).val();
        $('.advantage-sub-title').html(description);
    });
    $(document).on('click','.edit_advantage',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        Ladda.bind(this);
        var load = $(this).ladda();
        var url = "{{route('getFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'id' : id,
            'type':'advantage'
        };
        makeAjaxPost(data, url, load).done(function (response) {
            $('#serial_advantage').val(response.detail.serial);
            $('#detail_id_advantage').val(response.detail.id);
            $('#sub_title_advantage').val(response.detail.sub_title);
            $('#sub_description_advantage').val(response.detail.sub_description);
            var imagenUrl = response.detail.image;
            var drEvent = $('#image_advantage').dropify(
                {
                    defaultFile: imagenUrl
                });
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();
            drEvent.settings.defaultFile = imagenUrl;
            drEvent.destroy();
            drEvent.init();
            $('.submit_advantage_details').html('Save');
        });
    });
    $(document).on('click','.delete_advantage',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var landing_page_id = $('#landing_page_id').val();
        Ladda.bind(this);
        var load = $(this).ladda();
        var url = "{{route('deleteFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'type': 'advantage',
            id : id,
            landing_page_id:landing_page_id
        };
        makeAjaxPost(data, url, load).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_advantage').val(response.new_serial);
                $('#detail_id_advantage').val('');
                var drEvent = $('#image_advantage').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#sub_title_advantage').val('');
                $('#sub_description_advantage').val('');
                $('.submit_advantage_details').html('Add More');
                $('.advantage-details-view-'+id).remove();
                $('.advantage-details-'+id).remove();
                swalSuccess(response.message);
            }
        });
    });
</script>
