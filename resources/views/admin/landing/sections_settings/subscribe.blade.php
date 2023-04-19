<div class="accordion-item">
        <h2 class="accordion-header" id="flush-heading-{{$item->section_key}}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$item->section_key}}" aria-expanded="false" aria-controls="flush-collapse-{{$item->section_key}}">
                {{$item->section_name}}
            </button>
        </h2>
        <div id="flush-collapse-{{$item->section_key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$item->section_key}}" data-bs-parent="#accordionDashbord">
            <div class="accordion-body">
                <div class="section-show-hide">
                    <h3 class="sidebar-title">Subscription Info</h3>
                        <h3 class="sidebar-title">section show / hide</h3>
                        <label class="switch">
                            <input type="hidden" name="subscribe[section_id]" value="{{$section_parent->section_id}}">
                            <input type="hidden" name="subscribe[landing_page_id]" value="{{$active_page_id}}">
                            <input type="hidden" name="subscribe[page_key]" value="{{$active_page_key}}">
                            <input type="checkbox" id="status_subscribe" name="subscribe[status]" @if($section_parent->section_status) checked @endif value="1">
                            <span class="slider round"></span>
                        </label>
                        <h3 class="sidebar-title">Section Title</h3>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="section_title_subscribe" name="subscribe[section_title]" value="{{$section_parent->section_title}}" placeholder="Enter Title" />
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Description</label>
                            <input type="text" class="form-control" id="section_description_subscribe" name="subscribe[section_description]" value="{{$section_parent->section_description}}" placeholder="Enter Description" />
                        </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function()
    {
        $(document).on('change','#status_subscribe',function (e){
            const checked = $(this).is(':checked');
            if(checked){
                $(this).val(1);
                $('.subscribe-section').show();
            }else{
                $(this).val(0);
                $('.subscribe-section').hide();
            }
        });
        $(document).on('input','#section_title_subscribe',function (e){
            const title = $(this).val();
            $('.subscribe-section-title-main').html(title);
        });
        $(document).on('input','#section_description_subscribe',function (e){
            const description = $(this).val();
            $('.subscribe-section-subtitle-main').html(description);
        });
    });
</script>
