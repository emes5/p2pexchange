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
                    <input type="hidden" name="market_trend[section_id]" value="{{$section_parent->section_id}}">
                    <input type="checkbox" id="market_trend_status" name="market_trend[status]" @if($section_parent->section_status) checked @endif value="1">
                    <span class="slider round"></span>
                </label>
                <h3 class="sidebar-title">{{__('Add Information')}}</h3>
                <input type="hidden" name="market_trend[landing_page_id]" value="{{$active_page_id}}">
                <input type="hidden" name="market_trend[page_key]" value="{{$active_page_key}}">
                <div class="form-group">
                    <label for="about_title">{{__('Title')}}</label>
                    <input type="text" class="form-control" id="market_trend_title" name="market_trend[section_title]" value="{{$section_parent->section_title ?? ''}}" placeholder="Enter Section Title" />
                </div>
                <div class="form-group">
                    <label for="about_short_description">{{__('Description')}}</label>
                    <input type="text" class="form-control" id="market_trend_description" name="market_trend[section_description]" value="{{$section_parent->section_description ?? ''}}" placeholder="Enter Section Description" />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function()
    {
        $(document).on('change','#market_trend_status',function (e){
            const checked = $(this).is(':checked');
            if(checked){
                $(this).val(1);
                $('.market_trend-section').show();
            }else{
                $(this).val(0);
                $('.market_trend-section').hide();
            }
        });
        $(document).on('input','#market_trend_title',function (e){
            const title = $(this).val();
            $('.market-trend-title').html(title);
        });
        $(document).on('input','#market_trend_description',function (e){
            const description = $(this).val();
            $('.market-trend-sub-title').html(description);
        });
    });
</script>
