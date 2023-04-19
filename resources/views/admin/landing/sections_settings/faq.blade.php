<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">Faq Info</h3>
                    <h3 class="sidebar-title">section show / hide</h3>
                    <label class="switch">
                        <input type="hidden" name="faq[section_id]" value="{{$section_parent->section_id}}">
                        <input type="hidden" id="active_page_id_faq" name="faq[landing_page_id]" value="{{$active_page_id}}">
                        <input type="hidden" id="active_page_key_faq" name="faq[page_key]" value="{{$active_page_key}}">
                        <input type="checkbox" id="faq_status" name="faq[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <h3 class="sidebar-title">Section Title</h3>
                    <div class="form-group">
                        <label for="faq_section_title">Title</label>
                        <input type="text" class="form-control" id="faq_section_title" name="faq[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                    </div>
                    <div class="form-group">
                        <label for="faq_section_description">Description</label>
                        <input type="text" class="form-control" id="faq_section_description" name="faq[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                    </div>
                <h3 class="sidebar-title">Faq Details</h3>
                <div class="items-list faq-details-list">
                    @foreach($section_data as $section_details)
                        <div class="sngle-item faq-details-{{$section_details->id}}">
                            <div class="item-left">
                                <h4 class="item-title">{{$section_details->question}}</h4>
                            </div>
                            <div class="item-right">
                                <a href="#" class="edite edit_faq" data-id="{{$section_details->id}}"><i class="far fa-edit"></i></a>
                                <a href="#" class="delet delete_faq" data-id="{{$section_details->id}}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                    <input type="hidden" id="faq_section_id" name="section_id" value="{{$section_parent->section_id}}">
                    <input type="hidden" id="landing_page_id" name="landing_page_id" value="{{$active_page_id}}">
                    <input type="hidden" id="faq_page_key" name="page_key" value="{{$active_page_key}}">
                    <input type="hidden" id="detail_id_faq" name="id" value="">
                    <div class="item-group">
                        <input type="hidden" id="serial_faq" name="serial" value="{{getLastSerialOfFeature('faq',$active_page_id)+1}}">
                        <div class="form-group">
                            <label for="sub_title">Question</label>
                            <input type="text" id="question_faq" class="form-control" name="question" value="" placeholder="Enter Question" />
                        </div>
                        <div class="form-group">
                            <label for="sub_description">Answer</label>
                            <textarea class="form-control textarea" id="answer_faq" name="answer" cols="30" rows="10" placeholder="Enter Answer"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="add-btn submit_faq_details">{{__('Add More')}}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.submit_faq_details',function (e){
        e.preventDefault();
        var landing_page_id = $('#landing_page_id').val();
        var id = $('#detail_id_faq').val();
        if(id){
            var serial_number = $('#serial_number_'+id).html();
        }
        else{
            var a = parseFloat($('.total-'+landing_page_id).length)+1;
            var serial_number = a+'.';
        }
        var url = "{{route('saveFaqDetails')}}";
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('section_id', $('#faq_section_id').val());
        formData.append('landing_page_id', landing_page_id);
        formData.append('page_key', $('#faq_page_key').val());
        formData.append('id', id);
        formData.append('serial', $('#serial_faq').val());
        formData.append('question', $('#question_faq').val());
        formData.append('answer', $('#answer_faq').val());
        makeAjaxPostFile(formData, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_faq').val(response.data.new_serial);
                $('#detail_id_faq').val('');
                $('#question_faq').val('');
                $('#answer_faq').val('');
                $('.submit_faq_details').html('Add More');
                var exist = $("div").hasClass('faq-details-'+response.data.id);
                var html = '<div class="sngle-item faq-details-'+response.data.id+'">';
                var body_html = '<div class="item-left">'+
                    '<h4 class="item-title">'+response.data.question+'</h4></div>'+
                    '<div class="item-right"><a href="#" class="edite edit_faq" data-id="'+response.data.id+'"><i class="far fa-edit"></i></a>'+
                    '<a href="#" class="delet delete_faq" data-id="'+response.data.id+'"><i class="fas fa-trash"></i></a></div>';
                var footer_html = '</div>';
                if(exist){
                    $('.faq-details-'+response.data.id).html(body_html);
                }
                else{
                    $('.faq-details-list').append(html+body_html+footer_html);
                }

                var page_key = $('#active_page_key_faq').val();
                if(page_key!='custom_three'){
                    var detail_html_head = `<div class="accordion-item faq-details-view-${response.data.id}">`;
                    var detail_html_body = `<h2 class="accordion-header" id="heading${response.data.id}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${response.data.id}"
                                        aria-expanded="false" aria-controls="collapse${response.data.id}">
                                    <span id="serial_number_${response.data.id}">${serial_number}</span> ${response.data.question}</button></h2>
                                    <div id="collapse${response.data.id}" class="accordion-collapse collapse" aria-labelledby="heading-${response.data.id}" data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p>${response.data.answer}</p>
                                </div>
                            </div>`;
                    var detail_html_footer = `</div>`;
                    if(id){
                        $('.faq-details-view-'+response.data.id).html(detail_html_body);
                    }
                    else{
                        $('#accordionFaq').append(detail_html_head+detail_html_body+detail_html_footer);
                    }
                }else{
                    var detail_html_head = `<div class="card faq-card wow animate__fadeInUp total-${response.data.landing_page_id} faq-details-view-${response.data.id}" data-wow-duration="300ms">`;
                    var detail_html_body = `<div class="card-header" id="faq${response.data.id}">
                        <button class="btn btn-block collapsed" type="button"
                                data-toggle="collapse" data-target="#collapse${response.data.id}" aria-expanded="false"
                                aria-controls="collapse${response.data.id}">
                            ${response.data.question}
                        </button>
                        </div>
                        <div id="collapse${response.data.id}" class="collapse" aria-labelledby="faq${response.data.id}" data-parent="#faqAccordion">
                            <div class="card-body">
                                ${response.data.answer}
                            </div>
                        </div>`;
                    var detail_html_footer = `</div>`;
                    if(id){
                        $('.faq-details-view-'+response.data.id).html(detail_html_body);
                    }
                    else{
                        $('#faqAccordion').append(detail_html_head+detail_html_body+detail_html_footer);
                    }
                }
                swalSuccess(response.message);
            }
        });
    });
    $(document).on('change','#faq_status',function (e){
        const checked = $(this).is(':checked');
        if(checked){
            $(this).val(1);
            $('.faq-section').show();
        }else{
            $(this).val(0);
            $('.faq-section').hide();
        }
    });
    $(document).on('input','#faq_section_title',function (e){
        const title = $(this).val();
        $('.faq-section-title').html(title);
    });
    $(document).on('input','#faq_section_description',function (e){
        const description = $(this).val();
        $('.faq-section-subtitle').html(description);
    });
    $(document).on('click','.edit_faq',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{route('getFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'id' : id,
            'type':'faq'
        };
        makeAjaxPost(data, url).done(function (response) {
            $('#serial_faq').val(response.detail.serial);
            $('#detail_id_faq').val(response.detail.id);
            $('#question_faq').val(response.detail.question);
            $('#answer_faq').val(response.detail.answer);
            $('.submit_faq_details').html('Save');
        });
    });
    $(document).on('click','.delete_faq',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var landing_page_id = $('#landing_page_id').val();
        var url = "{{route('deleteFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'type': 'faq',
            id : id,
            landing_page_id:landing_page_id
        };
        makeAjaxPost(data, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_faq').val(response.new_serial);
                $('#detail_id_faq').val('');
                $('#question_faq').val('');
                $('#answer_faq').val('');
                $('.submit_faq_details').html('Add More');
                $('.faq-details-view-'+id).remove();
                $('.faq-details-'+id).remove();
                swalSuccess(response.message);
            }
        });
    });


</script>
