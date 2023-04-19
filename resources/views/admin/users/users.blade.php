@extends('admin.master',['menu'=>'users', 'sub_menu'=>'user'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('User management')}}</li>
                    <li class="active-item">{{__('User')}}</li>
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
                        <a data-id="active_users" class="nav-link active" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user" aria-selected="true">
                            <img src="{{asset('assets/admin/images/user-management-icons/user.svg')}}" class="img-fluid" alt="">
                            <span>{{__('User List')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="profile_tab" class="nav-link add_user" id="pills-add-user-tab" data-toggle="pill" href="#pills-add-user" role="tab" aria-controls="pills-add-user" aria-selected="true">
                            <img src="{{asset('assets/admin/images/user-management-icons/add-user.svg')}}" class="img-fluid" alt="">
                            <span>{{__('Add User')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="suspend_user" class="nav-link" id="pills-suspended-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-suspended-user" aria-selected="true">
                            <img src="{{asset('assets/admin/images/user-management-icons/block-user.svg')}}" class="img-fluid" alt="">
                            <span>{{__('Suspended User')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="deleted_user" class="nav-link" id="pills-deleted-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-deleted-user" aria-selected="true">
                            <img src="{{asset('assets/admin/images/user-management-icons/delete-user.svg')}}" class="img-fluid" alt="">
                            <span>{{__('Deleted User')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="email_pending" class="nav-link" id="pills-email-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-email" aria-selected="true">
                            <img src="{{asset('assets/admin/images/user-management-icons/email.svg')}}" class="img-fluid" alt="">
                            {{__('Email Pending')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="phone_pending" class="nav-link" id="pills-email-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-email" aria-selected="true">
                            <img src="{{asset('assets/admin/images/user-management-icons/email.svg')}}" class="img-fluid" alt="">
                            {{__('Phone Unverified')}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show active" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                        <div class="header-bar">
                            <div class="table-title">
                            </div>
                        </div>
                        <div class="table-area">
                            <div class=" table-responsive">
                                <table id="table" class="table table-borderless custom-table display text-center" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="all">{{__('Full Name')}}</th>
                                        <th scope="col" class="all">{{__('Username')}}</th>
                                        <th scope="col" class="desktop">{{__('Email')}}</th>
                                        <th scope="col" class="desktop">{{__('Status')}}</th>
                                        <th scope="col" class="desktop">{{__('Created At')}}</th>
                                        <th scope="col" class="all">{{__('Activity')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane add_user" id="pills-add-user" role="tabpanel" aria-labelledby="pills-add-user-tab">
                        <div class="header-bar">
                            <div class="table-title">
                                <h3>{{__('Add User')}}</h3>
                            </div>
                        </div>
                        <div class="add-user-form">
                            <form action="{{route('admin.UserAddEdit')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">{{__('First Name')}}</label>
                                            <input type="text" name="first_name" class="form-control" id="firstname" value="{{old('first_name')}}"  >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">{{__('Last Name')}}</label>
                                            <input name="last_name" type="text" class="form-control" id="lastname" value="{{old('last_name')}}"  >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">{{__('Username')}}</label>
                                            <input name="username" type="text" class="form-control" id="username" value="{{old('username')}}"  >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{__('Email')}}</label>
                                            <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{__('Country')}}</label>
                                            <select name="country" id="" class="form-control">
                                                <option value="">{{__('Select')}}</option>
                                                @if(!empty(countrylist()))
                                                    @foreach(countrylist() as $key => $value)
                                                        <option value="{{$key}}"
                                                                @if(old('country') == $key) selected @endif>
                                                            {{$value}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="button-primary theme-btn">{{__('Create')}}</button>
                                    </div>
                                </div>
                            </form>
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
        @if(isset($errors->all()[0]))
        $('.tab-pane').removeClass('active show');
        $('.nav-link').removeClass('active show');
        $('.add_user').addClass('active show');
        $('#profile-tab').addClass('active show');
        @endif

        function getTable(type) {

            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                retrieve: true,
                bLengthChange: true,
                responsive: true,
                ajax: '{{route('adminUsers')}}?type=' + type,
                order: [4, 'desc'],
                autoWidth: false,
                language: {
                    paginate: {
                        next: 'Next &#8250;',
                        previous: '&#8249; Previous'
                    }
                },
                columns: [
                    {"data": "first_name", "orderable": false},
                    {"data": "username", "orderable": true},
                    {"data": "email", "orderable": true},
                    {"data": "status", "orderable": false},
                    {"data": "created_at", "orderable": true},
                    {"data": "activity", "orderable": false}
                ],
            });

        }

        $(document.body).on('click', '.nav-link', function () {
            var id = $(this).data('id');
            if (id != 'undefined') {
                $('#table').DataTable().destroy();
                getTable(id)
                console.log(id)
            }

        });
        getTable('active_users');

    </script>
@endsection
