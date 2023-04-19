@extends('admin.master',['menu'=>'role', 'sub_menu'=>'admin_list'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Admin management')}}</li>
                    <li class="active-item">{{__('Admin')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management">
        <div class="row">
            <div class="col-12">
                <ul class="nav user-management-nav mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a data-id="active_users" class="nav-link user_list active" id="pills-user-list-tab" data-toggle="pill" href="#pills-user-list" role="tab" aria-controls="pills-user-list" aria-selected="true">
                            <img src="{{asset('assets/admin/images/user-management-icons/user.svg')}}" class="img-fluid" alt="">
                            <span>{{__('Admin List')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="profile_tab" class="nav-link add_user" id="pills-add-user-tab" data-toggle="pill" href="#pills-add-user" role="tab" aria-controls="pills-add-user" aria-selected="true">
                            <img src="{{asset('assets/admin/images/user-management-icons/add-user.svg')}}" class="img-fluid" alt="">
                            <span>{{__('Add Admin')}}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    @include('admin.admins.includes.admin_list_tab')
                    @include('admin.admins.includes.admin_add_tab')
                </div>
            </div>
        </div>
    </div>
    @include('admin.admins.includes.admin_action_modal')
    <!-- /User Management -->
@endsection

@section('script')
    @stack('custom-script')
    <script>
        $(document).ready(function (){

            @if(isset($errors->all()[0]))
                $('.tab-pane').removeClass('active show');
                $('.nav-link').removeClass('active show');
                $('.add_user').addClass('active show');
                $('#profile-tab').addClass('active show');
            @endif

            $(document.body).on('click', '.user_list', function () {
                $('.table').DataTable().destroy();
                getAdminListTable();
            });
            getAdminListTable();

            $(document).on('click','.action',function (){
                const userId = $(this).data('id');
                const type = $(this).data('type');
                let message = "Are you sure to "+ type +" this user?"
                swalConfirm(message).then(function (s){
                    if(s.value) {
                        $('#user_id').val(userId);
                        $('#action').val(type);
                        $('#userActionModalTitle').html('User '+type+' message');
                        $('#userActionModal').modal('show');
                    }
                });
            });

            $(document).on('click','.remove-gauth-action',function (){
                const id = $(this).data('id');
                const url = '{{url('admin')}}/user-remove-gauth-set-'+id;
                const message = "Are you sure to remove g2fa for this user?";
                swalConfirm(message).then(function (s){
                    if(s.value) {
                        makeAjaxText(url).done(function (response){
                            if (response.success === true){
                                swalRedirect("{{Request::url()}}",response.message,'success');
                            }else {
                                swalError(response.message);
                            }

                        })
                    }
                });
            })

            $(document).on('click','.verify-email-action',function (){
                const id = $(this).data('id');
                const url = '{{url('admin')}}/user-email-verify-'+id;
                const message = "Are you sure to verify email this user?";
                swalConfirm(message).then(function (s){
                    if(s.value) {
                        makeAjaxText(url).done(function (response){
                            if (response.success === true){
                                swalRedirect("{{Request::url()}}",response.message,'success');
                            }else {
                                swalError(response.message);
                            }

                        })
                    }
                });
            })
        })

        function getAdminListTable() {
            $('#user_table').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                pageLength: 10,
                retrieve: true,
                bLengthChange: true,
                responsive: true,
                ajax: '{{route('adminList')}}',
                order: [4, 'desc'],
                autoWidth: false,
                language: {
                "decimal":        "",
                "emptyTable":     "{{__('No data available in table')}}",
                "info":           "{{__('Showing')}} _START_ to _END_ of _TOTAL_ {{__('entries')}}",
                "infoEmpty":      "{{__('Showing')}} 0 to 0 of 0 {{__('entries')}}",
                "infoFiltered":   "({{__('filtered from')}} _MAX_ {{__('total entries')}})",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "{{__('Show')}} _MENU_ {{__('entries')}}",
                "loadingRecords": "{{__('Loading...')}}",
                "processing":     "",
                "search":         "{{__('Search')}}:",
                "zeroRecords":    "{{__('No matching records found')}}",
                "paginate": {
                    "first":      "{{__('First')}}",
                    "last":       "{{__('Last')}}",
                    "next":       '{{__('Next')}} &#8250;',
                    "previous":   '&#8249; {{__('Previous')}}'
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
                columns: [
                    {"data": "name", "orderable": true},
                    {"data": "email", "orderable": true},
                    {"data": "role_title", "orderable": true},
                    {"data": "status", "orderable": false},
                    {"data": "created_at", "orderable": false, "searchable": false},
                    {"data": "action", "orderable": false, "searchable": false}
                ],
            });
        }

    </script>
@endsection
