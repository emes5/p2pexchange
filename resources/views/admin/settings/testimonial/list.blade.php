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
                    <li>{{__('Landing Settings')}}</li>
                    <li class="active-item">{{__('Testimonial')}}</li>
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
                        <h3>{{__('Testimonial')}}</h3>
                    </div>
                    <div class="right d-flex align-items-center">
                        <div class="add-btn mb-2">
                            <a href="{{route('adminTestimonialAdd')}}">{{__('+ Add')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-area">
                        <div>
                            <table id="table" class="table table-borderless custom-table display text-center" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-left">{{__('Image')}}</th>
                                    <th class="">{{__('Name')}}</th>
                                    <th class="">{{__('Company ')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Updated At')}}</th>
                                    <th>{{__('Actions')}}</th>
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
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: '{{route('adminTestimonialList')}}',
            order: [4, 'desc'],
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "image","orderable": false},
                {"data": "name","orderable": false},
                {"data": "company_name","orderable": false},
                {"data": "status","orderable": false},
                {"data": "updated_at","orderable": false},
                {"data": "actions","orderable": false}
            ],
        });

    </script>
@endsection
