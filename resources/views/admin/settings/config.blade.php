@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'config'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-9">
                <ul>
                    <li>{{__('Setting')}}</li>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management p-4">
        <div class="row">
            <div class="col-12">
                <div class="header-bar p-4">
                    <div class="table-title">
                        <h3>{{ __('Some command that help you to config your system') }}</h3>
                    </div>
                </div>
                <div class="dashboard-status config-section">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 col-12 mb-xl-0 mb-4">
                            <div class=" configuration-box ">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Custom Token Deposit')}}</h3>
                                            <p>{{__('This command should run in your system every five minutes. It helps to deposit custom token. So try to run it every five minutes through scheduler. Otherwise you will miss user deposit')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_TOKEN_DEPOSIT)}}" class="theme-btn btn-success">{{__('Run Command')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12 mb-xl-0 mb-4">
                            <div class=" configuration-box">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Adjust Custom Token Deposit')}}</h3>
                                            <p>{{__('This command should run in your system every ten minutes once. It also helps to deposit custom token. So try to run it every ten minutes through scheduler. Otherwise you will miss user deposit')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_ADJUST_TOKEN_DEPOSIT)}}" class="theme-btn  btn-success">{{__('Run Command')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12 mb-xl-0 mb-4">
                            <div class=" configuration-box">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Clear Application Cache')}}</h3>
                                            <p>{{__('Clear all application cache by clicking this button and also you can run the cache clear command')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_CACHE)}}" class="theme-btn btn-success">{{__('Cache Clear')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12 mb-xl-0 mb-4">
                            <div class=" configuration-box">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Clear Application Config')}}</h3>
                                            <p>{{__('Reset or clear all configuration by clicking this button and also you can run the config clear command')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_CONFIG)}}" class="theme-btn  btn-success">{{__('Config Clear')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class=" configuration-box">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Clear Application View / Route')}}</h3>
                                            <p>{{__('By clicking this button you can clear the both view and route cache file')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_VIEW)}}" class="theme-btn  btn-success">{{__('View Clear')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12 mb-xl-0 mb-4">
                            <div class=" configuration-box">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Run Migration')}}</h3>
                                            <p>{{__('Migrate all db file')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_MIGRATE)}}" class="theme-btn  btn-success">{{__('Migrate')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class=" configuration-box">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Create Passport Client')}}</h3>
                                            <p>{{__('To create the personal access client ,you must run this command. please click this button or also run the command in terminal "php artisan passport:install"')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_PASSPORT_INSTALL)}}" class="theme-btn  btn-warning">{{__('Passport Install')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class=" configuration-box">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Create Missing Username')}}</h3>
                                            <p>{{__('To create the missing username ,you must run this command. please click this button or also run the command in terminal "php artisan create:username"')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_CREATE_USERNAME)}}" class="theme-btn  btn-warning">{{__('Create Username')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class=" configuration-box">
                                <div class="card-body ">
                                    <div class="configuration-box-inner">
                                        <div class="content">
                                            <h3>{{__('Run DB Seeder ')}}</h3>
                                            <p>{{__('To run the seeder ,you must run this command. please click this button or also run the command in terminal "php artisan create:username"')}}</p>
                                            <a href="{{route('adminRunCommand',COMMAND_TYPE_DB_SEEDER)}}" class="theme-btn  btn-warning">{{__('DB Seed')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    </script>
@endsection
