@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'custom_pages'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Settings')}}</li>
                    <li class="active-item">{{__('Custom Pages')}} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="user-management padding-30">
        <div class="row">
            <div class="col-12">
                <div class="header-bar">
                    <div class="table-title">
                        <h3>{{__('Custom Pages')}}</h3>
                    </div>
                    <div class="right d-flex align-items-center">
                        <div class="add-btn">
                            <a href="{{route('adminCustomPageAdd')}}">{{__('+ Add New Page')}}</a>
                        </div>
                    </div>
                </div>
                <div class="table-area">
                    <div>
                        <table class="table" id="table">
                            <thead>
                            <tr>
                                <th>{{__('Page Title')}}</th>
                                <th>{{__('Slug')}}</th>
                                <th>{{__('Created At')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody id="sortable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .user-area end -->
@endsection
@section('script')
    <script>
        $('#table').DataTable({
            processing: true,
            serverSide: true,
//            pageLength: 10,
            responsive: true,
            ajax: '{{route('adminCustomPageList')}}',
            order: [2, 'desc'],
            autoWidth:false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "title"},
                {"data": "key"},
                {"data": "created_at"},
                {"data": "actions"}
            ]
        });
    </script>
@endsection
