<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">Testimonial Info</h3>
                    <h3 class="sidebar-title">section show / hide</h3>
                    <label class="switch">
                        <input type="hidden" id="element_prefix" name="element_prefix" value="{{$element_prefix}}">
                        <input type="hidden" name="testimonial[section_id]" value="{{$section_parent->section_id}}">
                        <input type="hidden" name="testimonial[landing_page_id]" value="{{$active_page_id}}">
                        <input type="hidden" name="testimonial[page_key]" value="{{$active_page_key}}">
                        <input type="checkbox" id="status_testimonial" name="testimonial[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <h3 class="sidebar-title">Section Title</h3>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="section_title_testimonial" name="testimonial[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                    </div>
                    <div class="form-group">
                        <label for="sub_title">Description</label>
                        <input type="text" class="form-control" id="section_description_testimonial" name="testimonial[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                    </div>
                <h3 class="sidebar-title">Testimonial Details</h3>
                <div class="items-list testimonial-details-list">
                    @foreach($section_data as $section_details)
                        <div class="sngle-item testimonial-details-{{$section_details->id}}">
                            <div class="item-left">
                                <img class="item-image" src="{{check_storage_image_exists($section_details->image)}}" alt="btc" />
                                <h4 class="item-title">{{$section_details->sub_title}}</h4>
                            </div>
                            <div class="item-right">
                                <a href="#" class="edite edit_testimonial" data-id="{{$section_details->id}}"><i class="far fa-edit"></i></a>
                                <a href="#" class="delet delete_testimonial" data-id="{{$section_details->id}}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                    <input type="hidden" name="section_id_testimonial" id="section_id_testimonial" value="{{$section_parent->section_id}}">
                    <input type="hidden" id="landing_page_id_testimonial" name="landing_page_id" value="{{$active_page_id}}">
                    <input type="hidden" id="page_key_testimonial" name="page_key_testimonial" value="{{$active_page_key}}">
                    <input type="hidden" name="id" id="detail_id_testimonial" value="">
                    <div class="item-group">
                        <input type="hidden" name="serial" id="serial_testimonial" value="{{getLastSerialOfFeature('testimonial',$active_page_id)+1}}">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="dropify" id="image_testimonial" />
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title</label>
                            <input type="text" class="form-control" id="sub_title_testimonial" name="sub_title" value="" placeholder="Enter Sub Title" />
                        </div>
                        <div class="form-group">
                            <label for="sub_description">Sub Description</label>
                            <textarea class="form-control textarea" name="sub_description" id="sub_description_testimonial" cols="30" rows="10" placeholder="Enter Sub Descripton"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="add-btn submit_testimonial_details">{{__('Add More')}}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.submit_testimonial_details',function (e){
        e.preventDefault();
        var landing_page_id = $('#landing_page_id_testimonial').val();
        var id = $('#detail_id_testimonial').val();
        var url = "{{route('saveTestimonialDetails')}}";
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('section_id', $('#section_id_testimonial').val());
        formData.append('landing_page_id', landing_page_id);
        formData.append('page_key', $('#page_key_testimonial').val());
        formData.append('id', id);
        formData.append('serial', $('#serial_testimonial').val());
        formData.append('sub_title', $('#sub_title_testimonial').val());
        formData.append('sub_description', $('#sub_description_testimonial').val());
        if(typeof $('#image_testimonial')[0].files[0] !== 'undefined'){
            formData.append('image', $('#image_testimonial')[0].files[0]);
        }
        makeAjaxPostFile(formData, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                var page_key = $('#page_key_testimonial').val();
                var drEvent = $('#image_testimonial').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#serial_testimonial').val(response.data.new_serial);
                $('#detail_id_testimonial').val('');
                $('#sub_title_testimonial').val('');
                $('#sub_description_testimonial').val('');
                $('.submit_testimonial_details').html('Add More');
                var exist = $("div").hasClass('testimonial-details-'+response.data.id);
                var html = '<div class="sngle-item testimonial-details-'+response.data.id+'">';
                var body_html = '<div class="item-left">'+
                    '<img class="item-image" src="'+response.data.image+'" alt="'+response.data.sub_title+'" />'+
                    '<h4 class="item-title">'+response.data.sub_title+'</h4></div>'+
                    '<div class="item-right"><a href="#" class="edite edit_testimonial" data-id="'+response.data.id+'"><i class="far fa-edit"></i></a>'+
                    '<a href="#" class="delet delete_testimonial" data-id="'+response.data.id+'"><i class="fas fa-trash"></i></a></div>';
                var footer_html = '</div>';
                if(exist){
                    $('.testimonial-details-'+response.data.id).html(body_html);
                }
                else{
                    $('.testimonial-details-list').append(html+body_html+footer_html);
                }
                if(page_key=='custom_three'){
                    var detail_html_head = `<div class="item testimonial-details-view-${response.data.id}">`;
                    var detail_html_body = `<div class="row align-items-center">
                                <div class="col-lg-4"><img src="${response.data.image}" class="img-fluid testimonial-image" alt=""></div>
                                <div class="col-lg-6">
                                    <h3 class="testimonial-title">${response.data.sub_title}</h3>
                                    <p class="testimonial-content">${response.data.sub_description}</p>
                                </div>
                            </div>`;
                    var detail_html_footer = `</div>`;
                    if(id){
                        $('.testimonial-details-view-'+response.data.id).html(detail_html_body);
                    }
                    else{
                        $('.testimonial-details-container').append(detail_html_head+detail_html_body+detail_html_footer);
                    }
                }else{
                    var detail_html_head = `<div class="single-testimonial testimonial-details-view-${response.data.id}">`;
                    var detail_html_body_head = `<img class="testimonial-image" src="${response.data.image}" alt="testimonial-image" />`;
                    var detail_html_body = '';
                    var suffix = $('#element_prefix').val();
                    if(response.element_prefix){
                        detail_html_body = `<div class="quote-icon">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <p class="testimonial-content">${response.data.sub_description}</p>
                            <h4 class="testimonial-profession">${response.data.sub_title}</h4>`;
                    }else{
                        detail_html_body = `<h3 class="testimonial-title">${response.data.sub_title}</h3>
                    <p class="testimonial-content">${response.data.sub_description}</p>`;
                    }
                    var detail_html_footer = `</div>`;
                    if(id){
                        $('.testimonial-details-view-'+response.data.id).html(detail_html_body_head+detail_html_body);
                    }
                    else{
                        $('.testimonial-details-container').append(detail_html_head+detail_html_body_head+detail_html_body+detail_html_footer);
                    }
                }
                swalSuccess(response.message);
            }
        });
    });

    $(document).on('change','#status_testimonial',function (e){
        const checked = $(this).is(':checked');
        if(checked){
            $(this).val(1);
            $('.testimonial-section').show();
        }else{
            $(this).val(0);
            $('.testimonial-section').hide();
        }
    });
    $(document).on('input','#section_title_testimonial',function (e){
        const title = $(this).val();
        $('.section-title-testimonial-main').html(title);
    });
    $(document).on('input','#section_description_testimonial',function (e){
        const description = $(this).val();
        $('.section-subtitle-testimonial-main').html(description);
    });
    $(document).on('click','.edit_testimonial',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{route('getFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'id' : id,
            'type':'testimonial'
        };
        makeAjaxPost(data, url).done(function (response) {
            var imagenUrl = response.detail.image;
            var drEvent = $('#image_testimonial').dropify(
                {
                    defaultFile: imagenUrl
                });
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();
            drEvent.settings.defaultFile = imagenUrl;
            drEvent.destroy();
            drEvent.init();
            $('#serial_testimonial').val(response.detail.serial);
            $('#detail_id_testimonial').val(response.detail.id);
            $('#sub_title_testimonial').val(response.detail.sub_title);
            $('#sub_description_testimonial').val(response.detail.sub_description);
            $('.submit_testimonial_details').html('Save');
        });
    });
    $(document).on('click','.delete_testimonial',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var landing_page_id = $('#landing_page_id').val();
        var url = "{{route('deleteFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'type': 'testimonial',
            id : id,
            landing_page_id:landing_page_id
        };
        makeAjaxPost(data, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                var drEvent = $('#image_testimonial').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#serial_testimonial').val(response.new_serial);
                $('#detail_id_testimonial').val('');
                $('#sub_title_testimonial').val('');
                $('#sub_description_testimonial').val('');
                $('.submit_testimonial_details').html('Add More');
                $('.testimonial-details-view-'+id).remove();
                $('.testimonial-details-'+id).remove();
                var suffix = $('#element_prefix').val();
                $('.testimonial-slide'+suffix).not('.slick-initialized').slick();
                swalSuccess(response.message);
            }
        });
    });


</script>
