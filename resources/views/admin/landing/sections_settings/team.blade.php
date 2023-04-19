<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">Team Info</h3>
                    <h3 class="sidebar-title">section show / hide</h3>
                    <label class="switch">
                        <input type="hidden" name="team[section_id]" value="{{$section_parent->section_id}}">
                        <input type="hidden" name="team[landing_page_id]" value="{{$active_page_id}}">
                        <input type="hidden" name="team[page_key]" value="{{$active_page_key}}">
                        <input type="checkbox" id="team_status" name="team[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <h3 class="sidebar-title">Section Title</h3>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="section_title_team" name="team[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                    </div>
                    <div class="form-group">
                        <label for="sub_title">Description</label>
                        <input type="text" class="form-control" id="section_description_team" name="team[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                    </div>
                <h3 class="sidebar-title">Team Details</h3>
                <div class="items-list team-details-list">
                    @foreach($section_data as $section_details)
                        <div class="sngle-item team-details-{{$section_details->id}}">
                            <div class="item-left">
                                <img class="item-image" src="{{check_storage_image_exists($section_details->image)}}" alt="btc" />
                                <h4 class="item-title">{{$section_details->sub_title}}</h4>
                            </div>
                            <div class="item-right">
                                <a href="#" class="edite edit_team" data-id="{{$section_details->id}}"><i class="far fa-edit"></i></a>
                                <a href="#" class="delet delete_team" data-id="{{$section_details->id}}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                    <input type="hidden" name="section_id" id="team_section_id" value="{{$section_parent->section_id}}">
                    <input type="hidden" id="landing_page_id" name="landing_page_id" value="{{$active_page_id}}">
                    <input type="hidden" name="page_key" id="team_page_key" value="{{$active_page_key}}">
                    <input type="hidden" name="id" id="detail_id_team" value="">
                    <div class="item-group">
                        <input type="hidden" name="serial" id="serial_team" value="{{getLastSerialOfFeature('team',$active_page_id)+1}}">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="dropify" id="image_team" />
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title</label>
                            <input type="text" class="form-control" id="sub_title_team" name="sub_title" value="" placeholder="Enter Sub Title" />
                        </div>
                        <div class="form-group">
                            <label for="sub_description">Sub Description</label>
                            <textarea class="form-control textarea" name="sub_description" id="sub_description_team" cols="30" rows="10" placeholder="Enter Sub Descripton"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="facebook_team">Facebook</label>
                            <input type="text" class="form-control" id="facebook_team" name="facebook" value="" placeholder="Enter Link" />
                        </div>
                        <div class="form-group">
                            <label for="linkedin_team">Linkedin</label>
                            <input type="text" class="form-control" id="linkedin_team" name="linkedin" value="" placeholder="Enter Link" />
                        </div>
                        <div class="form-group">
                            <label for="twitter_team">Twitter</label>
                            <input type="text" class="form-control" id="twitter_team" name="twitter" value="" placeholder="Enter Link" />
                        </div>
                    </div>
                    <button type="submit" class="add-btn submit_team_details">{{__('Add More')}}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.submit_team_details',function (e){
        e.preventDefault();
        var landing_page_id = $('#landing_page_id').val();
        var id = $('#detail_id_team').val();
        var url = "{{route('saveTeamDetails')}}";
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('section_id', $('#team_section_id').val());
        formData.append('landing_page_id', landing_page_id);
        formData.append('page_key', $('#team_page_key').val());
        formData.append('id', id);
        formData.append('serial', $('#serial_team').val());
        formData.append('sub_title', $('#sub_title_team').val());
        formData.append('sub_description', $('#sub_description_team').val());
        formData.append('facebook', $('#facebook_team').val());
        formData.append('linkedin', $('#linkedin_team').val());
        formData.append('twitter', $('#twitter_team').val());
        if(typeof $('#image_team')[0].files[0] !== 'undefined'){
            formData.append('image', $('#image_team')[0].files[0]);
        }
        makeAjaxPostFile(formData, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                var drEvent = $('#image_team').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#serial_team').val(response.data.new_serial);
                $('#detail_id_team').val('');
                $('#sub_title_team').val('');
                $('#sub_description_team').val('');
                $('#facebook_team').val('');
                $('#linkedin_team').val('');
                $('#twitter_team').val('');
                $('.submit_team_details').html('Add More');
                var exist = $("div").hasClass('team-details-'+response.data.id);
                var html = '<div class="sngle-item team-details-'+response.data.id+'">';
                var body_html = '<div class="item-left">'+
                    '<img class="item-image" src="'+response.data.image+'" alt="'+response.data.sub_title+'" />'+
                    '<h4 class="item-title">'+response.data.sub_title+'</h4></div>'+
                    '<div class="item-right"><a href="#" class="edite edit_team" data-id="'+response.data.id+'"><i class="far fa-edit"></i></a>'+
                    '<a href="#" class="delet delete_team" data-id="'+response.data.id+'"><i class="fas fa-trash"></i></a></div>';
                var footer_html = '</div>';
                if(exist){
                    $('.team-details-'+response.data.id).html(body_html);
                }
                else{
                    $('.team-details-list').append(html+body_html+footer_html);
                }
                var detail_html_body='';
                var detail_html_head = `<div class="col-lg-4 col-md-6 team-details-view-${response.data.id}">`;
                if(response.element_prefix){
                    detail_html_body = `<div class="single-team text-center">
                        <div class="team-image">
                            <img src="${response.data.image}" alt="team-two-image" />
                            <div class="team-overlay">
                                <ul class="social-meida">
                                    <li><a href="${response.data.facebook}"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="${response.data.twitter}"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="${response.data.linkedin}"><i class="fab fa-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <h3 class="team-name">${response.data.sub_title}</h3>
                        <h4 class="team-designation">${response.data.sub_description}</h4>
                    </div>`;
                }else{
                    detail_html_body = `<div class="single-team text-center">
                        <div class="team-image"><a href="javascript:void(0)">
                        <img src="${response.data.image}" alt="team image" />
                        </a></div>
                        <h3 class="team-name"><a href="#">${response.data.sub_title}</a></h3>
                        <p class="team-info">${response.data.sub_description}</p>
                        <ul class="social-media">
                            <li><a href="${response.data.facebook}"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="${response.data.twitter}"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="${response.data.linkedin}"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>`;
                }
                var detail_html_footer = `</div>`;
                if(id){
                    $('.team-details-view-'+response.data.id).html(detail_html_body);
                }
                else{
                    $('.team-details-container').append(detail_html_head+detail_html_body+detail_html_footer);
                }
                swalSuccess(response.message);
            }
        });
    });

    $(document).on('change','#team_status',function (e){
        const checked = $(this).is(':checked');
        if(checked){
            $(this).val(1);
            $('.team-section').show();
        }else{
            $(this).val(0);
            $('.team-section').hide();
        }
    });
    $(document).on('input','#section_title_team',function (e){
        const title = $(this).val();
        $('.section-title-team-main').html(title);
    });
    $(document).on('input','#section_description_team',function (e){
        const description = $(this).val();
        $('.section-subtitle-team-main').html(description);
    });
    $(document).on('click','.edit_team',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{route('getFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'id' : id,
            'type':'team'
        };
        makeAjaxPost(data, url).done(function (response) {
            var imagenUrl = response.detail.image;
            var drEvent = $('#image_team').dropify(
                {
                    defaultFile: imagenUrl
                });
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();
            drEvent.settings.defaultFile = imagenUrl;
            drEvent.destroy();
            drEvent.init();
            $('#serial_team').val(response.detail.serial);
            $('#detail_id_team').val(response.detail.id);
            $('#sub_title_team').val(response.detail.sub_title);
            $('#sub_description_team').val(response.detail.sub_description);
            $('#facebook_team').val(response.detail.facebook);
            $('#linkedin_team').val(response.detail.linkedin);
            $('#twitter_team').val(response.detail.twitter);
            $('.submit_team_details').html('Save');
        });
    });
    $(document).on('click','.delete_team',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var landing_page_id = $('#landing_page_id').val();
        var url = "{{route('deleteFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'type': 'team',
            id : id,
            landing_page_id:landing_page_id
        };
        makeAjaxPost(data, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_team').val(response.new_serial);
                $('#detail_id_team').val('');
                var drEvent = $('#image_team').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                $('#sub_title_team').val('');
                $('#sub_description_team').val('');
                $('#facebook_team').val('');
                $('#linkedin_team').val('');
                $('#twitter_team').val('');
                $('.submit_team_details').html('Add More');
                $('.team-details-view-'+id).remove();
                $('.team-details-'+id).remove();
                swalSuccess(response.message);
            }
        });
    });
</script>
