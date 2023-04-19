<!DOCTYPE html>
<html class="no-js" lang="en">
@if($active_page_key == 'custom_three')
    @include('admin.landing.includes.head_master')
@else
    @include('admin.landing.includes.head')
@endif
<body id="home">
<style>
    :root {
        --primary-color{{$element_prefix}}: {{$temp_primary_color}};
        --hover-color{{$element_prefix}}: {{$temp_hover_color}};
    }
</style>

@if(isset($settings['font_enable']) && $settings['font_enable'])
    @if(!empty($settings['font_file_name']))
        <style>
            @font-face {
                font-family: "My font";
                font-style: normal;
                font-weight: 400;
                font-display: block;
                src: url({{asset('assets/landing/custom/assets/fonts/'.$settings['font_file_name'])}});
                src: url({{asset('assets/landing/custom/assets/fonts/'.$settings['font_file_name'])}}) format("truetype");
            }
            :root {
                --primary-font: "My font";
            }
        </style>
    @endif
@endif
<form class="saveSectionForm" id="saveSectionForm" action="{{route('saveSection')}}" method="POST">
    @csrf
<div class="dashbord-sidebar">
    <div class="sidebar-top">
        <a class="close-btn" href="{{route('adminDashboard')}}"><i class="fas fa-times"></i></a>
        <button class="save-btn btn-success save_n_publish">save & publish</button>
    </div>
    <div class="customizing-area">
        <h4>we are customizing</h4>
        <h3>develop laravel</h3>
    </div>
    <div class="theme-select-area">
        <div class="form-group">
            <label class="select-theme-title">Select Landing Page</label>
            <select class="form-control" name="landing_page_id" id="landing_page_id">
                @foreach($pages as $key=>$page)
                    <option value="{{$key}}" @if($key==$active_page_id) selected @endif>{{$page['page_title']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <input type="hidden" id="element_prefix" name="element_prefix" value="{{$element_prefix}}">

    <div class="row" style="margin-right:15px;margin-left: 15px;">
        <div class="col-6 text-center">
            <div class="form-group">
                <label class="select-theme-title d-block">Primary Color</label>
                <input type="color" id="temp_primary_color" name="temp_primary_color" value="{{$temp_primary_color}}">
            </div>
        </div>
        <div class="col-6 text-center">
            <div class="form-group">
                <label class="select-theme-title d-block">Hover Color</label>
                <input type="color" id="temp_hover_color" name="temp_hover_color" value="{{$temp_hover_color}}">
            </div>
        </div>
    </div>
    <div class="item-scroll">
        <div class="accordion accordion-flush dashbord-accordion" id="accordionDashbord">
            @foreach($sections as $item)
                @include('admin.landing.sections_settings.'.$item->section_key,['section_parent'=>$item,'section_data'=>$section_data[$item->section_key]])
            @endforeach
        </div>
    </div>
    <div class="sidebar-bottom">
        <button type="submit" class="btn-primary add-btn submit_section">update</button>
    </div>
    <button type="button" class="collapse-btn"><i class="fas fa-angle-left"></i></button>
</div>
</form>

<form class="d-none" id="pageReload" action="{{route('landingPageSettings')}}" method="GET">
    <input type="hidden" id="page_id_form" name="page_id" value="">
</form>



<div class="main-content">
    @include('admin.landing.landing_page.'.$active_page_key)
</div>


<script>
    $(document).ready(function() {
        submitOperation(submitResponseSection, 'submit_section');
        function submitResponseSection(response, this_form) {
            if (response.success) {
                swalSuccess(response.message);
            } else {
                swalError(response.message);
            }
        }
        $(document).on('change','#landing_page_id',function (e){
            e.preventDefault();
            var page_id = $(this).val();
            $('#page_id_form').val(page_id);
            $('#pageReload').submit();
        });
        $(document).on('change','#temp_primary_color',function (e){
            e.preventDefault();
            var color_code = $(this).val();
            var landing_page_id = $('#landing_page_id').val();
            var url = "{{route('savePrimaryColor')}}";
            var data = {
                '_token': "{{ csrf_token() }}",
                'color_code':color_code,
                'landing_page_id':landing_page_id
            };
            makeAjaxPost(data, url).done(function (response) {
                if(response.success === false) {
                    swalError(response.message);
                } else {
                    $('#temp_primary_color').val(response.data.temp_primary_color);
                    document.documentElement.style.setProperty('--primary-color'+response.element_prefix, response.data.temp_primary_color);
                    swalSuccess(response.message);
                }
            });
        });
        $(document).on('change','#temp_hover_color',function (e){
            e.preventDefault();
            var color_code = $(this).val();
            var landing_page_id = $('#landing_page_id').val();
            var url = "{{route('saveHoverColor')}}";
            var data = {
                '_token': "{{ csrf_token() }}",
                'color_code':color_code,
                'landing_page_id':landing_page_id
            };
            makeAjaxPost(data, url).done(function (response) {
                if(response.success === false) {
                    swalError(response.message);
                } else {
                    $('#temp_hover_color').val(response.data.temp_hover_color);
                    document.documentElement.style.setProperty('--hover-color'+response.element_prefix, response.data.temp_hover_color);
                    swalSuccess(response.message);
                }
            });
        });
        $(document).on('click','.save_n_publish',function (e){
            e.preventDefault();
            var landing_page_id = $('#landing_page_id').val();
            var url = "{{route('saveAndPublish')}}";
            var data = {
                '_token': "{{ csrf_token() }}",
                'landing_page_id':landing_page_id
            };
            makeAjaxPost(data, url).done(function (response) {
                if(response.success === false) {
                    swalError(response.message);
                } else {
                    swalSuccess(response.message);
                }
            });
        });
    });
</script>
@if($active_page_key == 'custom_three')
    @include('admin.landing.includes.footer_master_assets')
@else
    @include('admin.landing.includes.footer_assets')
@endif




</body>
</html>
