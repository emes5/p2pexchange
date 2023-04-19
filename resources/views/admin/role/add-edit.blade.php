@extends('admin.master',['menu'=>'role', 'sub_menu'=>'role_section'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-9">
                <ul>
                    <li>{{__('Role Management')}}</li>
                    @if(isset($role))
                        <li class="active-item">{{ 'Role Edit' }}</li>
                    @else
                        <li class="active-item">{{ 'Role Add' }}</li>
                    @endif
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
                    <div class="text-right">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-area">
                        <form action="{{ route('roleAddEdit') }}" method="post">
                            @csrf
                            @if(isset($role))
                                <input type="hidden" name="id" value="{{ $role->id }}">
                            @endif
                        <div>
                                <div class="form-group">
                                    <label>Role Name</label>
                                    <input class="form-control" @if(isset($role)) value="{{ $role->title }}" @endif style="width: 30%" name="title" type="text">
                                </div>
                        </div>
                        <hr>
                        <div style="">
                            <div class="row">
                                <?php
                                $num_count = 0;
                                $old_id = null;
                                ?>
                                @foreach(getPermissionField() as $name => $row)
                                    @continue(!$row[0]['status'])
                                    <div class="col-3">
                                        {{ $row[0]['for'] }}
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col-8">
                                        @foreach($row as $field)
                                            @continue(!$field['status'])
                                            @php
                                                $checked = false;
                                            @endphp
                                            @if(isset($permission))
                                                @foreach($permission as $per)
                                                    @if($per->name == $field['name'])
                                                        @php
                                                            $checked = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                            <?php $field['name'] = ($old_id == $field['name']) ? 'something' : $field['name'] ; ?>
                                            <input id="{{ $field['name'].$num_count }}" type="checkbox" <?php echo $checked ? 'checked' : '' ?> value="{{ $field['name'] }}" name="{{ $field['name'] }}"> <label for="{{ $field['name'].$num_count }}" >{{ $field['title'] }}</label>
                                            <?php $old_id = $field['name']; ?>
                                        @endforeach
                                    </div>
                                        <?php $num_count++; ?>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <input value="Create" class="btn btn-primary" style="width: 20%" type="submit">
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
