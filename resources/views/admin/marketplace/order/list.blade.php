@extends('admin.master',['menu'=>'order', 'sub_menu'=>$sub_menu])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-9">
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
                <div class="header-bar p-4">
                    <div class="table-title">
                        <h3>{{ $title }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-area">
                        <div>
                            <table id="table" class="table table-borderless custom-table display text-center" width="100%">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('Buyer')}}</th>
                                    <th scope="col">{{__('Seller')}}</th>
                                    <th scope="col">{{__('Coin Type')}}</th>
                                    <th scope="col">{{__('Coin Rate')}}</th>
                                    <th scope="col">{{__('Amount')}}</th>
                                    <th scope="col">{{__('Price')}}</th>
                                    <th scope="col">{{__('Status')}}</th>
                                    <th scope="col">{{__('Reported')}}</th>
                                    <th scope="col">{{__('Created At')}}</th>
                                    <th scope="col">{{__('Activity')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->

@endsection

@section('script')
    <script>
        (function($) {
            "use strict";

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                retrieve: true,
                bLengthChange: true,
                responsive: true,
                ajax: '{{route('orderList')}}',
                order: [8, 'desc'],
                autoWidth: false,
                language: {
                    paginate: {
                        next: 'Next &#8250;',
                        previous: '&#8249; Previous'
                    }
                },
                columns: [
                    {"data": "buyer_id", "orderable": false},
                    {"data": "seller_id", "orderable": false},
                    {"data": "coin_type", "orderable": false},
                    {"data": "rate", "orderable": false},
                    {"data": "amount", "orderable": false},
                    {"data": "price", "orderable": false},
                    {"data": "status", "orderable": false},
                    {"data": "is_reported", "orderable": false},
                    {"data": "created_at", "orderable": true},
                    {"data": "activity", "orderable": false}
                ],
            });
        })(jQuery);
    </script>
@endsection
