@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'custom_pages'])
@section('title',isset($cp) ? 'Update Custom Page' : 'Add Custom Page')
@section('style')
@endsection
@section('content')
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Custom Pages')}}</li>
                    <li class="active-item">{{$title}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="user-management add-custom-page">
        <div class="row">
            <div class="col-12">
                <div class="header-bar">
                    <div class="table-title">
                        <h3>{{$title}}</h3>
                    </div>
                </div>
                <div class="profile-info-form">
                    <form action="{{route('adminCustomPageSave')}}" method="post">
                        @if(!empty($cp->id))
                            <input type="hidden" name="edit_id" value="{{$cp->id}}">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-xl-0 mb-4">
                                <div class="form-group">
                                    <label>{{__('Page Title')}}</label>
                                    <input type="text" class="form-control" id="page_title" name="title" placeholder="{{__('Title')}}" @if(isset($cp))value="{{$cp->title}}" @else value="{{old('title')}}" @endif>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Slug')}}</label>
                                    <input type="text" class="form-control check_slug_validity" name="key" placeholder="{{__('Slug')}}" @if(isset($cp))value="{{$cp->key}}" @else value="{{old('key')}}" @endif>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('Description')}}</label>
                                    <textarea name="description" id="btEditor" cols="30" rows="10" class="form-control">@if(isset($cp)){!! $cp->description !!} @else {{old('description')}} @endif</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn add-faq-btn">
                                        @if(isset($cp)) {{__('Update')}} @else {{__('Submit')}} @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- .user-area end -->
@endsection
<script src="{{asset('assets/landing/custom/assets/js/sweetalert/sweetalert2.all.min.js')}}"></script>
<link href="{{asset('assets/landing/custom/assets/js/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{asset('assets/landing/custom/assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/admin/js/ckeditor.js')}}"></script>
@section('script')

    <script>
        $(document).ready(function()
        {
            $(document).on('input','#page_title',function (e){
                const page_title = $(this).val();
                var url = "{{route('customPageSlugCheck')}}";
                var data = {
                    '_token': '{{ csrf_token() }}',
                    'title': page_title,
                };
                if(typeof $('#edit_id').val()!=='undefined'){
                    data.id = $('#edit_id').val();
                }
                $.ajax({
                    url : url,
                    type : 'GET',
                    data : data,
                    dataType:'json',
                    success : function(data) {
                        $('.check_slug_validity').val(data.slug);
                    },
                    error : function(request,error)
                    {
                        //alert('Error');
                    }
                });

            });
        });
    </script>

    <script src="{{asset('assets/admin/js/ckeditor.js')}}"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor',function () {
                config.width = 500;
            } ) )
            .catch( error => {
                //console.error( error );
            } );
    </script>
{{--    <script>--}}
{{--        CKEDITOR.replace( '#editor', {--}}
{{--            uiColor: '#14B8C4',--}}
{{--            toolbar: [--}}
{{--                [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],--}}
{{--                [ 'FontSize', 'TextColor', 'BGColor' ]--}}
{{--            ],--}}
{{--            width:['250px']--}}

{{--        });--}}

{{--    </script>--}}


@endsection
