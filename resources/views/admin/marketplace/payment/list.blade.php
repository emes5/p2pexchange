@extends('admin.master',['menu'=>'payment_method'])
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
                    <div class="right d-flex align-items-center">
                        <div class="add-btn">
                            <a href="{{route('addPaymentMethod')}}">{{__('+ Add New')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-area payment-table-area">
                        <div class="table-responsive">
                            <table id="table" class="table table-borderless custom-table display text-center" width="100%">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('Method Name')}}</th>
                                    <th scope="col">{{__('Image')}}</th>
                                    <th scope="col">{{__('Status')}}</th>
                                    <th scope="col">{{__('Created at')}}</th>
                                    <th scope="col">{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($items[0]))
                                    @foreach($items as $value)
                                    <tr>
                                        <td> {{$value->name}} </td>
                                        <td> <img src="{{$value->image}}" alt="" width="50"> </td>
                                        <td>
                                            <div>
                                                <label class="switch">
                                                    <input type="checkbox" onclick="return processForm('{{$value->id}}')"
                                                           id="notification" name="security" @if($value->status == STATUS_ACTIVE) checked @endif>
                                                    <span class="slider" for="status"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td> {{$value->created_at}} </td>
                                        <td>
                                            <ul class="d-flex activity-menu">
                                                <li class="viewuser"><a title="{{__('Edit')}}" href="{{route('editPaymentMethod', [($value->unique_code)])}}"><i class="fa fa-pencil"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td>{{__('No data found')}}</td>
                                    </tr>
                                @endif
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

        function processForm(active_id) {
            $.ajax({
                type: "POST",
                url: "{{ route('paymentMethodStatusChange') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'active_id': active_id
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
