<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
            {{$item->section_name}}
        </button>
    </h2>
    <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
        <div class="accordion-body">
            <div class="section-show-hide">
                <h3 class="sidebar-title">Coin buy OR Sell</h3>
                    <h3 class="sidebar-title">section show / hide</h3>
                    <label class="switch">
                        <input type="hidden" name="coin_buy_sell[section_id]" value="{{$section_parent->section_id}}">
                        <input type="hidden" name="coin_buy_sell[landing_page_id]" value="{{$active_page_id}}">
                        <input type="hidden" id="active_page_key_coin" name="coin_buy_sell[page_key]" value="{{$active_page_key}}">
                        <input type="checkbox" id="coin_status" name="coin_buy_sell[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                @if($active_page_key!='custom_three')
                    <h3 class="sidebar-title">Section Title</h3>
                    <div class="form-group">
                        <label for="coin_section_title">Title</label>
                        <input type="text" class="form-control" id="coin_section_title" name="coin_buy_sell[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                    </div>
                    <div class="form-group">
                        <label for="coin_section_description">Description</label>
                        <input type="text" class="form-control" id="coin_section_description" name="coin_buy_sell[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                    </div>
                @endif
                <h3 class="sidebar-title">Coin Addition</h3>
                <div class="items-list coin-buy-sell-details-list">
                    @foreach($section_data as $section_details)
                        <div class="sngle-item coin-buy-sell-detail-{{$section_details->id}}">
                            <div class="item-left">
                                <img class="item-image" src="{{show_image_path($section_details->image,'')}}" alt="btc" />
                                <h4 class="item-title">{{$section_details->name}}</h4>
                            </div>
                            <div class="item-right">
                                <a href="#" class="edite edit_coin_buy_sell" data-id="{{$section_details->id}}"><i class="far fa-edit"></i></a>
                                <a href="#" class="delet delete_coin_buy_sell" data-id="{{$section_details->id}}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                    <input type="hidden" name="section_id" id="coin_section_id" value="{{$section_parent->section_id}}">
                    <input type="hidden" id="landing_page_id" name="landing_page_id" value="{{$active_page_id}}">
                    <input type="hidden" id="coin_page_key" name="page_key" value="{{$active_page_key}}">
                    <input type="hidden" name="id" id="detail_id_coin_buy_sell" value="">
                    <div class="item-group">
                        <input type="hidden" name="serial" id="serial_coin_buy_sell" value="{{getLastSerialOfFeature('coin',$active_page_id)+1}}">
                        <div class="form-group">
                            <label class="select-theme-title">Select Coin</label>
                            <select name="coin_id" id="coin_id" class="form-control">
                                <option value="">Select Coin</option>
                                @foreach($coins as $coin)
                                    <option value="{{$coin->id}}">{{$coin->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sub_description">Sub Description</label>
                            <textarea class="form-control textarea" name="sub_description" id="sub_description_coin_buy_sell" cols="30" rows="10" placeholder="Enter Sub Descripton"></textarea>
                        </div>
                    </div>
                    <button type="button" class="add-btn submit_coin_buy_sell_details">{{__('Add More')}}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.submit_coin_buy_sell_details',function (e){
        e.preventDefault();
        var landing_page_id = $('#landing_page_id').val();
        var id = $('#detail_id_coin_buy_sell').val();
        var url = "{{route('saveCoinBuySellDetails')}}";
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('section_id', $('#coin_section_id').val());
        formData.append('landing_page_id', landing_page_id);
        formData.append('page_key', $('#coin_page_key').val());
        formData.append('id', id);
        formData.append('serial', $('#serial_coin_buy_sell').val());
        formData.append('coin_id', $('#coin_id').val());
        formData.append('sub_description', $('#sub_description_coin_buy_sell').val());
        makeAjaxPostFile(formData, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_coin_buy_sell').val(response.data.new_serial);
                $('#detail_id_coin_buy_sell').val('');
                $('.submit_coin_buy_sell_details').html('Add More');
                $('#coin_id').val('');
                $('#sub_description_coin_buy_sell').val('');
                var exist = $("div").hasClass('coin-buy-sell-detail-'+response.data.id);
                var html = '<div class="sngle-item coin-buy-sell-detail-'+response.data.id+'">';
                var body_html = '<div class="item-left">'+
                    '<img class="item-image" src="'+response.coin_image+'" alt="'+response.coin_name+'" />'+
                    '<h4 class="item-title">'+response.coin_name+'</h4></div>'+
                    '<div class="item-right"><a href="#" class="edite edit_coin_buy_sell" data-id="'+response.data.id+'"><i class="far fa-edit"></i></a>'+
                    '<a href="#" class="delet delete_coin_buy_sell" data-id="'+response.data.id+'"><i class="fas fa-trash"></i></a></div>';
                var footer_html = '</div>';
                if(exist){
                    $('.coin-buy-sell-detail-'+response.data.id).html(body_html);
                }
                else{
                    $('.coin-buy-sell-details-list').append(html+body_html+footer_html);
                }

                var active_page_key = $('#active_page_key_coin').val();
                if(active_page_key!='custom_three'){
                    var url_ex = '{{url("exchange")}}'+'?coin_type='+response.coin_type;
                    var detail_html_head = '<div class="col-lg-4 col-md-6 coin-details-view-'+response.data.id+'">';
                    var detail_html_body = '<div class="single-trading-coin text-center">'+
                        '<img class="trading-coin-image" src="'+response.coin_image+'" alt="trading-coin" />'+
                        '<h3 class="trading-coin-title">'+response.coin_name+'</h3>'+
                        '<p class="trading-coin-info">'+response.data.sub_description+'</p>'+
                        '<div class="buy-sell-area">'+
                        '<a href="'+url_ex+'" class="primary-btn">{{__('buy')}}</a>'+
                        '<a href="'+url_ex+'" class="primary-btn">{{__('sell')}}</a>'+
                        '</div>'+
                        '</div>';
                    var detail_html_footer = '</div>';
                }else{
                    var url_ex = '{{url("exchange")}}'+'?coin_type='+response.coin_type;
                    var detail_html_head = '<div class="col-lg-6 mb-4 wow animate__fadeInUp coin-details-view-'+response.data.id+'" data-wow-duration="300ms">';
                    var detail_html_body = `<div class="coin-card">
                            <div class="icon">
                                <img src="${response.coin_image}" class="img-fluid" alt="">
                            </div>
                            <h3>${response.coin_name}</h3>
                            <p>${response.data.sub_description}</p>
                            <div class="btn-group">
                                <a href="`+url_ex+`" class="btn buy-sale-btn buy-sale-btn-1">{{__('buy')}}</a>
                                <a href="`+url_ex+`" class="btn buy-sale-btn buy-sale-btn-2">{{__('sell')}}</a>
                            </div>
                        </div>`;
                    var detail_html_footer = '</div>';
                }
                if(id){
                    $('.coin-details-view-'+response.data.id).html(detail_html_body);
                }
                else{
                    $('.coin-details-container').append(detail_html_head+detail_html_body+detail_html_footer);
                }
                swalSuccess(response.message);
            }
        });
    });
    $(document).on('change','#coin_status',function (e){
        const checked = $(this).is(':checked');
        if(checked){
            $(this).val(1);
            $('.coin_buy_sell-section').show();
        }else{
            $(this).val(0);
            $('.coin_buy_sell-section').hide();
        }
    });
    $(document).on('input','#coin_section_title',function (e){
        const title = $(this).val();
        $('.coin-section-title').html(title);
    });
    $(document).on('input','#coin_section_description',function (e){
        const description = $(this).val();
        $('.coin-section-subtitle').html(description);
    });
    $(document).on('click','.edit_coin_buy_sell',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{route('getFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'id' : id,
            'type':'coin'
        };
        makeAjaxPost(data, url).done(function (response) {
            $('#serial_coin_buy_sell').val(response.detail.serial);
            $('#detail_id_coin_buy_sell').val(response.detail.id);
            $('#coin_id').val(response.detail.coin_id)
            $('#sub_description_coin_buy_sell').val(response.detail.sub_description);
            $('.submit_coin_buy_sell_details').html('Save');
        });
    });
    $(document).on('click','.delete_coin_buy_sell',function (e){
        e.preventDefault();
        var id = $(this).data('id');
        var landing_page_id = $('#landing_page_id').val();
        var url = "{{route('deleteFeatureData')}}";
        var data = {
            '_token': "{{ csrf_token() }}",
            'type': 'coin',
            id : id,
            landing_page_id : landing_page_id
        };
        makeAjaxPost(data, url).done(function (response) {
            if(response.success === false) {
                swalError(response.message);
            } else {
                $('#serial_coin_buy_sell').val(response.new_serial);
                $('#detail_id_coin_buy_sell').val('');
                $('#coin_id').val('');
                $('#sub_description_coin_buy_sell').val('');
                $('.submit_coin_buy_sell_details').html('Add More');
                $('.coin-details-view-'+id).remove();
                $('.coin-buy-sell-detail-'+id).remove();
                swalSuccess(response.message);
            }
        });
    });
</script>
