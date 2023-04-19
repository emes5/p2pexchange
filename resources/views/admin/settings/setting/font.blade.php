<div class="header-bar">
    <div class="table-title">
        <h3>{{__('Font Setup (Site)')}}</h3>
    </div>
</div>
<div class="profile-info-form">
    <form action="{{route('adminSaveFontSettings')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-6 col-12  mt-20">
                <div class="form-group">
                    <label>{{__('Font Enable/Disable')}}</label><br>
                    <label class="switch">
                        <input @if(isset($settings['font_enable']) && $settings['font_enable']) checked @endif name="font_enable" type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="col-lg-6 col-12  mt-20">
                <div class="form-group">
                    <label>{{__('Select Font Family')}}</label>
                    <select name="font_file_path" id="font_link" class="form-control">
                        <option value="">Choose Font Family</option>
                        @foreach ($fonts->items as $item)
                            @isset($item->files->regular)
                                <option value="{{$item->files->regular}}" @if(isset($settings['font_file_path']) && ($item->files->regular==$settings['font_file_path'])) selected @endif >{{$item->family}}</option>
                            @endisset
                        @endforeach
                    </select>
                    <input type="hidden" id="font_file_name" name="font_file_name" value="{{$settings['font_file_name'] ?? ''}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-12 mt-20">
                <button type="submit" class="button-primary theme-btn">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).on('change', '#font_link', function (e) {
        e.preventDefault();
        if($(this).val()){
            var font_link = $(this).val();
            var data = {
                '_token' : '{{csrf_token()}}',
                'file_path' : font_link
            };
            $.ajax({
                type: "POST",
                url: '{{route('downloadAndStoreFontFile')}}',
                data: data,
                success: function (response) {
                    if(response.status==true){
                        $('#font_file_name').val(response.data.file_name);
                    }
                    else{
                        SweetAlert('Font file not found. Please try again!');
                    }
                }
            });
        }
    });
</script>
