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
                        <input type="hidden" name="trade_anywhere[section_id]" value="{{$section_parent->section_id}}">
                        <input type="checkbox" id="status_trade" name="trade_anywhere[status]" @if($section_parent->section_status) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <h3 class="sidebar-title">{{__('Add Information')}}</h3>
                    <input type="hidden" name="trade_anywhere[section_detail_id]" id="section_detail_id_trade" value="{{$section_data[0]->id}}">
                    <input type="hidden" name="trade_anywhere[landing_page_id]" id="landing_page_id_trade" value="{{$active_page_id}}">
                    <input type="hidden" name="trade_anywhere[page_key]" id="page_key_trade" value="{{$active_page_key}}">
                    <div class="form-group">
                        <label for="title">{{__('Trade Section Title')}}</label>
                        <input type="text" class="form-control" id="section_title_trade" name="trade_anywhere[section_title]" value="{{$section_parent->section_title ?? ''}}" placeholder="Enter Banner Title" />
                    </div>
                    <div class="form-group">
                        <label for="title">{{__('Trade Section Description')}}</label>
                        <input type="text" class="form-control" id="section_description_trade" name="trade_anywhere[section_description]" value="{{$section_parent->section_description ?? ''}}" placeholder="Enter Short Description" />
                    </div>
                    <div class="form-group">
                        <label for="image_one">{{__('Left Image (611×419)')}}</label>
                        <input type="file" class="dropify" data-default-file="{{check_storage_image_exists($section_data[0]->image_one)}}" id="image_one_trade" name="trade_anywhere[image_one]" />
                    </div>
                    <div class="form-group">
                        <label for="image_two">{{__('Right Image (240×240)')}}</label>
                        <input type="file" class="dropify" id="image_two_trade" data-default-file="{{check_storage_image_exists($section_data[0]->image_two)}}" name="trade_anywhere[image_two]" />
                    </div>
                    <div class="form-group">
                        <label for="app_store_link">{{__('App Store Link')}}</label>
                        <input type="text" class="form-control" id="app_store_link_trade" name="trade_anywhere[app_store_link]" value="{{$section_data[0]->app_store_link ?? ''}}" placeholder="App Store Link" />
                    </div>
                    <div class="form-group">
                        <label for="play_store_link">{{__('Play Store Link')}}</label>
                        <input type="text" class="form-control" id="play_store_link_trade" name="trade_anywhere[play_store_link]" value="{{$section_data[0]->play_store_link ?? ''}}" placeholder="Play Store Link" />
                    </div>
                    <div class="form-group">
                        <label for="android_apk_link">{{__('Android Apk Link')}}</label>
                        <input type="text" class="form-control" id="android_apk_link_trade" name="trade_anywhere[android_apk_link]" value="{{$section_data[0]->android_apk_link ?? ''}}" placeholder="Android APK Link" />
                    </div>
                    <div class="form-group">
                        <label for="windows_link">{{__('Windows Link')}}</label>
                        <input type="text" class="form-control" id="windows_link_trade" name="trade_anywhere[windows_link]" value="{{$section_data[0]->windows_link ?? ''}}" placeholder="Windows Link" />
                    </div>
                    <div class="form-group">
                        <label for="linux_link">{{__('Linux Link')}}</label>
                        <input type="text" class="form-control" id="linux_link_trade" name="trade_anywhere[linux_link]" value="{{$section_data[0]->linux_link ?? ''}}" placeholder="linux Link" />
                    </div>
                    <div class="form-group">
                        <label for="mac_link">{{__('Mac Link')}}</label>
                        <input type="text" class="form-control" id="mac_link_trade" name="trade_anywhere[mac_link]" value="{{$section_data[0]->mac_link ?? ''}}" placeholder="Mac Link" />
                    </div>
                    <div class="form-group">
                        <label for="api_link">{{__('API Link')}}</label>
                        <input type="text" class="form-control" id="api_link_trade" name="trade_anywhere[api_link]" value="{{$section_data[0]->api_link ?? ''}}" placeholder="API Link" />
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function()
    {
        $(document).on('change','#status_trade',function (e){
            const checked = $(this).is(':checked');
            if(checked){
                $(this).val(1);
                $('.trade_anywhere-section').show();
            }else{
                $(this).val(0);
                $('.trade_anywhere-section').hide();
            }
        });
        $(document).on('input','#section_title_trade',function (e){
            const title = $(this).val();
            $('.trade-title-main').html(title);
        });
        $(document).on('input','#section_description_trade',function (e){
            const description = $(this).val();
            $('.trade-sub-title-main').html(description);
        });

        $(document).on('change','#image_one_trade',function (e){
            const [file] = this.files
            if (file) {
                $("#image_one_trade-main").attr('src',URL.createObjectURL(file));
            }
        });

        $(document).on('change','#image_two_trade',function (e){
            const [file] = this.files
            if (file) {
                $("#image_two_trade-main").attr('src',URL.createObjectURL(file));
            }
        });

        var drEvent1 = $('#image_one_trade').dropify();
        var drEvent2 = $('#image_two_trade').dropify();
        drEvent1.on('dropify.afterClear', function(event, element) {
            $("#image_one_trade-main").attr('src','');
        });
        drEvent2.on('dropify.afterClear', function(event, element) {
            $("#image_two_trade-main").attr('src','');
        });
    });
</script>
