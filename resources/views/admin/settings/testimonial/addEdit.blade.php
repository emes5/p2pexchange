@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'testimonial'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Testimonial')}}</li>
                    <li class="active-item">{{$title}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management add-custom-page">
        <div class="row">
            <div class="col-12">
                <div class="header-bar">
                    <div class="table-title">
                        <h3>{{$title}}</h3>
                    </div>
                </div>
                <div class="profile-info-form">
                    <form action="{{route('adminTestimonialSave')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 mb-xl-0 mb-4">
                                <div class="form-group">
                                    <label>{{__('Client Name')}}</label>
                                    <input type="text" name="name" class="form-control" @if(isset($item)) value="{{$item->name}}" @else value="{{old('name')}}" @endif>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Client designation')}}</label>
                                    <input type="text" name="designation" class="form-control" @if(isset($item)) value="{{$item->designation}}" @else value="{{old('designation')}}" @endif>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Company name')}}</label>
                                    <input type="text" name="company_name" class="form-control" @if(isset($item)) value="{{$item->company_name}}" @else value="{{old('company_name')}}" @endif>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Activation Status')}}</label>
                                    <select name="status" class="form-control wide" >
                                        @foreach(status() as $key => $value)
                                            <option @if(isset($item) && ($item->status == $key)) selected
                                                    @elseif((old('status') != null) && (old('status') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-xl-0 mb-4">
                                <div class="form-group">
                                    <label>{{__('Messages')}}</label>
                                    <textarea class="form-control textarea" name="messages">@if(isset($item)){{$item->messages}}@else{{old('messages')}}@endif</textarea>
                                </div>
                                <div class="form-group buy_coin_address_input ">
                                    <label>{{__('Image')}}</label>
                                    <div id="file-upload" class="section-p">
                                        <input type="file" placeholder="0.00" name="image" value=""
                                               id="file" ref="file" class="dropify"
                                               @if(isset($item->image) && (!empty($item->image)))  data-default-file="{{$item->image}}" @endif />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    @if(isset($item))
                                        <input type="hidden" name="edit_id" value="{{$item->id}}">
                                    @endif
                                    <button type="submit" class="btn add-faq-btn">{{__('Save')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->

@endsection

@section('script')
@endsection
