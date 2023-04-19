<div class="tab-pane add_user" id="pills-add-user" role="tabpanel" aria-labelledby="pills-add-user-tab">
    <div class="header-bar">
        <div class="table-title">
            <h3>{{__('Add User')}}</h3>
        </div>
    </div>
    <div class="add-user-form">
        <form action="{{route('adminAddEdit')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstname">{{__('First Name')}}</label>
                        <input type="text" name="first_name" class="form-control" id="firstname" value="{{old('first_name')}}"  placeholder="First Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstname">{{__('Last Name')}}</label>
                        <input type="text" name="last_name" class="form-control" id="lastname" value="{{old('last_name')}}"  placeholder="Last Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">{{__('Nick Name')}}</label>
                        <input name="username" type="text" class="form-control" id="lastname" value="{{old('username')}}"  placeholder="User Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">{{__('Email')}}</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}" placeholder="Email address">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('Role')}}</label>
                        <div class="cp-select-area">
                            <select name="role" class="wide form-control">
                                <option value="">{{__('Select')}}</option>
                                @if(isset($roles))
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="hidden" name="default_module_id" value="{{USER_ROLE_ADMIN}}">
                    <button class="button-primary theme-btn">{{__('Save')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
