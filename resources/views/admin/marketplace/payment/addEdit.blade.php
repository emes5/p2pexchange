@extends('admin.master',['menu'=>'payment_method'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Crypto Exchange')}}</li>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management">
        <div class="row">
            <div class="col-12">
                <div class="profile-info-form">
                    <div class="card-body">
                        <form action="{{route('paymentMethodSave')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mt-20">
                                    <div class="form-group">
                                        <label for="firstname">{{__('Method Name')}}</label>
                                        <input type="text" name="name" class="form-control" id="firstname" placeholder="{{__('Payment method name')}}"
                                               @if(isset($item)) value="{{$item->name}}" @else value="{{old('name')}}" @endif>
                                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label>{{__('Select Country')}}</label>
                                        <div class="cp-select-area">
                                            <select multiple name="country[]" class=" selectpicker form-control" id="select-payment-method" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                                                @foreach(countrylist() as $key => $value)
                                                    <option @if(isset($item) && in_array($key,$selected_country)) selected @endif  value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label>{{__('Activation Status')}}</label>
                                        <div class="cp-select-area">
                                            <select name="status" class="form-control wide" >
                                                @foreach(status() as $key => $value)
                                                    <option @if(isset($item) && ($item->status == $key)) selected
                                                            @elseif((old('status') != null) && (old('status') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                                    <span class="text-danger"><strong>{{ $errors->first('status') }}</strong></span>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-20">
                                    <div class="form-group">
                                        <label>{{__('Short Note (Optional)')}}</label>
                                        <textarea name="details" id="" rows="2" class="form-control">@if(isset($item)){{$item->details}}@else{{old('details')}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-20">
                                    <div class="single-uplode">
                                        <div class="uplode-catagory">
                                            <span>{{__('Payment logo')}}</span>
                                        </div>
                                        <div class="form-group buy_coin_address_input ">
                                            <div id="file-upload" class="section-p">
                                                <input type="file" placeholder="0.00" name="image" value=""
                                                       id="file" ref="file" class="dropify"
                                                       @if(isset($item))  data-default-file="{{$item->image}}" @endif />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @if(isset($item))
                                        <input type="hidden" name="edit_id" value="{{$item->id}}">
                                    @endif
                                    <button class="button-primary theme-btn">@if(isset($item)) {{__('Update')}} @else {{__('Create')}} @endif</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->

@endsection

@section('script')
@endsection
