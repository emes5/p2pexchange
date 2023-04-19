@extends('admin.master',['menu'=>'coin'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-9">
                <ul>
                    <li>{{__('Coin')}}</li>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management add-custom-page">
        <div class="row">
            <div class="col-12">
                <div class="header-bar p-4">
                    <div class="table-title">
                        <h3>{{ $title }}</h3>
                    </div>
                </div>
                <div class="profile-info-form">
                    <div class="card-body">
                        {{Form::open(['route'=>'adminCoinUpdate', 'files' => true])}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Coin Full Name')}}</div>
                                        <input type="text" class="form-control" name="name" @if(isset($item))value="{{$item->name}}" @else value="{{old('name')}}" @endif>
                                        <pre class="text-danger">{{$errors->first('name')}}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Withdrawal fees (%)')}}</div>
                                        <input type="text" class="form-control" name="withdrawal_fees" @if(isset($item))value="{{$item->withdrawal_fees}}" @else value="{{old('withdrawal_fees')}}" @endif>
                                        <pre class="text-danger">{{$errors->first('withdrawal_fees')}}</pre>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Maximum Withdrawal Per Day')}}</div>
                                        <input type="text" class="form-control" name="max_withdrawal_per_day" @if(isset($item))value="{{$item->max_withdrawal_per_day}}" @else value="{{old('max_withdrawal_per_day')}}" @endif>
                                        <pre class="text-danger">{{$errors->first('max_withdrawal_per_day')}}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Minimum Withdrawal')}}</div>
                                        <input type="text" class="form-control" name="minimum_withdrawal"
                                               @if(isset($item))value="{{$item->minimum_withdrawal}}" @else value="0.00000001" @endif >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Maximum Withdrawal')}}</div>
                                        <input type="text" class="form-control" name="maximum_withdrawal"
                                               @if(isset($item))value="{{$item->maximum_withdrawal}}" @else value="99999999" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Minimum Trade Size')}}</div>
                                        <input type="text" class="form-control" name="minimum_trade_size"
                                               @if(isset($item))value="{{$item->minimum_trade_size}}" @else value="0.00000001" @endif >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Maximum Trade Size')}}</div>
                                        <input type="text" class="form-control" name="maximum_trade_size"
                                               @if(isset($item))value="{{$item->maximum_trade_size}}" @else value="99999999" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Trade Fees (%)')}}</div>
                                        <input type="text" class="form-control" name="trade_fees"
                                               @if(isset($item))value="{{$item->trade_fees}}" @else value="0.00000001" @endif >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Escrow Fees (%)')}}</div>
                                        <input type="text" class="form-control" name="escrow_fees"
                                               @if(isset($item))value="{{$item->escrow_fees}}" @else value="99999999" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="details">{{__('Details')}}</label>
                                    <textarea type="text" class="form-control" name="details" id="details" placeholder="{{__('Add coin details in here...')}}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Withdrawal Status')}}</div>
                                        <label class="switch">
                                            <input type="checkbox" name="is_withdrawal" @if(isset($item) && $item->is_withdrawal==1)checked  @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Buy Status')}}</div>
                                        <label class="switch">
                                            <input type="checkbox" name="is_buy" @if(isset($item) && $item->is_buy==1)checked  @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Sell Status')}}</div>
                                        <label class="switch">
                                            <input type="checkbox" name="is_sell" @if(isset($item) && $item->is_sell==1)checked  @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-label">{{__('Active Status')}}</div>
                                        <label class="switch">
                                            <input type="checkbox" name="status" @if(isset($item) && $item->status==1)checked  @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-label">{{__('Coin Icon')}}</div>
                                <div class="form-group  ">
                                    <div id="file-upload" class="section-p">
                                        <input type="file" placeholder="0.00" name="coin_icon" value=""
                                               id="file" ref="file" class="dropify"
                                               @if(isset($item->image) && (!empty($item->image)))  data-default-file="{{show_image_path($item->image,'')}}" @endif />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                @if(isset($item))<input type="hidden" name="coin_id" value="{{encrypt($item->id)}}">  @endif
                                <button type="submit" class="btn btn-success">{{$button_title}}</button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->

@endsection

@section('script')
@endsection
