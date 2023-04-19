@extends('admin.master',['menu'=>'order', 'sub_menu'=>'payment_window'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Settings')}}</li>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management padding-30">
        <div class="row">
            <div class="col-12">
                <div class="header-bar">
                    <div class="table-title">
                        <h3>{{ $title }}</h3>
                    </div>
                    <div class="right d-flex align-items-center">
                        <div class="add-btn mb-2">
                            <a href="{{route('adminPaymentWindowAdd')}}">{{__('+ Add')}}</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if(isset($items[0]))
                        @foreach($items as $item)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        {{ $item->payment_time }} {{__('Minutes')}}
                                        <span class="float-right">
                                            <ul class="d-flex ">
                                                <li><a class="text-info" href="{{ route('adminPaymentWindowEdit', $item->id) }}"><i class="fa fa-pencil-square"></i></a></li>
                                                <li><a class="text-danger ml-1" href="{{ route('adminPaymentWindowDelete', $item->id) }}"><i class="fa fa-trash"></i></a></li>
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <p class="text-danger text-center">{{__('No data found')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->

@endsection

@section('script')

@endsection
