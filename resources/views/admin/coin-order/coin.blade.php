@extends('admin.master',['menu'=>'coin'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-9">
                <ul>
                    <li>{{__('Coin')}}</li>
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
                        <div class="add-btn-new mb-2">
                            <a href="{{route('adminCoinList',['update'=> 'coinPayment'])}}">{{__('Adjust Coin With CoinPayment')}}</a>
                        </div>
                    </div>
                </div>
                <div class="table-area">
                    <div>
                        <table id="table" class=" table table-borderless custom-table display text-center" width="100%">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Coin Name')}}</th>
                                <th scope="col">{{__('Coin Type')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th scope="col">{{__('Updated At')}}</th>
                                <th scope="col">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($coins))
                            @foreach($coins as $coin)
                                <tr>
                                    <td> {{$coin->name}} </td>
                                    <td> {{check_default_coin_type($coin->type)}} </td>
                                    <td>
                                        <div>
                                            <label class="switch">
                                                <input type="checkbox" onclick="return processForm('{{$coin->id}}')"
                                                       id="notification" name="security" @if($coin->status == STATUS_ACTIVE) checked @endif>
                                                <span class="slider" for="status"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td> {{$coin->updated_at}}</td>
                                    <td>
                                        <a href="{{route('adminCoinEdit', $coin->unique_code)}}" class="btn btn-danger coin-edit">
                                            {{__('Edit')}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->
    <!-- Update form in modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="updateModalLabel">{{__('Edit Details')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateForm" action="{{route('adminCoinUpdate')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="icon">{{__('Coin Icon')}}</label>
                            <div id="dropify_container">
                                <input type="file" class="form-control dropify" id="icon" name="icon">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="details">{{__('Details')}}</label>
                            <textarea type="text" class="form-control" name="details" required id="details" placeholder="{{__('Add coin details in here...')}}"></textarea>
                        </div>
                        <input type="text" id="coin_id" name="id" hidden>
                    </div>
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">{{__('Update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('#table').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering:  true,
            select: false,
            bDestroy: true
        });
        function processForm(active_id) {

            $.ajax({
                type: "POST",
                url: "{{ route('adminCoinStatus') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'active_id': active_id
                },
                success: function (data) {
                }
            });
        }

        $(document).on('click', '.coin-edit', function () {
            var id = $(this).data('id');
            var details = $(this).data('details');
            var icon = $(this).data('icon');

            $('#coin_id').val(id);
            $('#details').val(details);
            if (icon !== '') {
                html = `<input type="file" class="form-control dropify" id="icon" name="icon" data-max-file-size="5M" data-default-file="{{asset(IMG_PATH)}}/` + icon + `"/>`;
            } else {
                html = `<input type="file" class="form-control dropify" id="icon" name="icon"/>`;
            }
            $('#dropify_container').html(html);
            $('#icon').dropify();
        });

    </script>
@endsection
