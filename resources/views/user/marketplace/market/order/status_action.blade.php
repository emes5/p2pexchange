@include('user.marketplace.market.order.status_header')
<div class="row">
    <div class="col-12">
        @if($item->status == TRADE_STATUS_TRANSFER_DONE)
            <div class="cp-user-card-header-area">
                <div class="title">
                    <h3 id="list_title2" class="text-success">{{__('Transaction Successful')}}</h3>
                </div>
            </div>
            @if($type == 'seller' && is_null($item->seller_feedback))
                <form action="{{route('updateFeedback')}}" method="POST" enctype="multipart/form-data"
                      id="">
                    @csrf
                    <div class="feedback-wraper">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="cp-user-payment-type mb-3">
                                    <input type="hidden" name="order_id" value="{{$item->id}}">
                                    <input type="hidden" name="type" value="{{$type}}">
                                    <h3 class="text-success">{{__('Now you can give feedback to ')}} {{$type == 'seller' ? __('Buyer') : __('Seller')}}</h3>
                                    <select required name="seller_feedback" class=" form-control" >
                                        <option value="">{{__('Select feedback')}}</option>
                                        @foreach(feedback_status() as $key => $value)
                                            <option @if(old('seller_feedback') == $key) selected @endif value="{{$key}}">{!! $value !!}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-warning"><strong>{{__('Once you update the feedback you never change it')}}</strong></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="cp-user-payment-type feedback-btn">
                                    <button class="btn btn-info" type="submit">{{__('Submit Feedback For Buyer')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
            @if($type == 'buyer' && is_null($item->buyer_feedback))
                <form action="{{route('updateFeedback')}}" method="POST" enctype="multipart/form-data"
                      id="">
                    @csrf
                    <div class="feedback-wraper">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="cp-user-payment-type mt-1">
                                    <input type="hidden" name="order_id" value="{{$item->id}}">
                                    <input type="hidden" name="type" value="{{$type}}">
                                    <h3 class="text-success">{{__('Now you can give feedback to ')}} {{$type == 'seller' ? __('Buyer') : __('Seller')}}</h3>
                                    <select required name="buyer_feedback" class=" form-control" >
                                        <option value="">{{__('Select feedback')}}</option>
                                        @foreach(feedback_status() as $key => $value)
                                            <option @if(old('buyer_feedback') == $key) selected @endif value="{{$key}}">{!! $value !!}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-warning"><strong>{{__('Once you update the feedback you never change it')}}</strong></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="cp-user-payment-type feedback-btn">
                                    <button class="btn btn-info" type="submit">{{__('Submit Feedback For Seller')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            @endif
        @endif

        @if($item->is_reported == STATUS_ACTIVE)
            @if(isset($report))
                <div class="cp-user-card-header-area">
                    <div class="title">
                        <h4 id="list_title2" class="text-danger">
                            @if($report->type == BUYER) {{__('The buyer ')}} @else {{__('The seller ')}} @endif {{__(' reported against order.')}}
                        </h4>
                        @if(!empty($item->transaction_id))
                            <h5 class="text-warning">{{ $item->transaction_id }}</h5>
                        @endif
                    </div>
                </div>
            @endif
        @else
            <ul class="d-flex">
                @if($type == 'seller')
                    @if($item->status == TRADE_STATUS_INTERESTED)
                        <li class="deleteuser mr-3">
                            <a title="{{__('Fund Escrow')}}" href="#escrow_{{($item->id)}}" data-toggle="modal">
                                <button class="btn theme-btn">{{__('Fund Escrow')}}</button>
                            </a>
                        </li>
                        <div id="escrow_{{($item->id)}}" class="modal fade delete" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header"><h6 class="modal-title">{{__('Escrow')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                    @if(isset($check_balance))
                                        <div class="modal-body">
                                            <p>{{__('Do you want to escrow ?')}}</p>
                                            @if($check_balance['success'] == false)
                                                <p class="text-danger">{{ $check_balance['message'] }}</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                            @if($check_balance['success'] == true)
                                                <a class="btn btn-danger" href="{{route('fundEscrow', encrypt($item->id))}}">{{__('Confirm')}}</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($item->status == TRADE_STATUS_PAYMENT_DONE)
                        <li class="deleteuser mr-3">
                            <a title="{{__('Release Escrow')}}" href="#escrow_{{($item->id)}}" data-toggle="modal">
                                <button class="btn theme-btn">{{__('Release Escrow')}}</button>
                            </a>
                        </li>
                        <div id="escrow_{{($item->id)}}" class="modal fade delete" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header"><h6 class="modal-title">{{__('Release Escrow')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                    <div class="modal-body"><p>{{__('Do you want to release escrow ?')}}</p></div>
                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                        <a class="btn btn-danger" href="{{route('releasedEscrow', encrypt($item->id))}}">{{__('Confirm')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($item->status == TRADE_STATUS_INTERESTED || $item->status == TRADE_STATUS_ESCROW)
                        <li class="deleteuser mr-3">
                            <a title="{{__('Cancel Trade')}}" href="#cancel_{{($item->id)}}" data-toggle="modal">
                                <button class="btn theme-btn">{{__('Cancel Trade')}}</button>
                            </a>
                        </li>
                        <div id="cancel_{{($item->id)}}" class="modal fade delete" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header"><h6 class="modal-title">{{__('Cancel')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                    <div class="modal-body">
                                        <p>{{__('Do you want to cancel order ?')}}</p>
                                        <form action="{{route('tradeCancel')}}" method="POST" enctype="multipart/form-data"
                                              id="">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{encrypt($item->id)}}">
                                            <input type="hidden" name="type" value="{{SELLER}}">
                                            <div class="cp-user-payment-type">
                                                <h3>{{__('Reason')}} </h3>
                                                <textarea name="reason" required class="form-control"></textarea>
                                            </div>
                                            <button type="submit" class=" mt-4 btn theme-btn">{{__('Submit')}}</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if($type == 'buyer')
                    @if($item->status == TRADE_STATUS_INTERESTED)
                        <li class="deleteuser mr-3">
                            <a title="{{__('Cancel Trade')}}" href="#cancel_{{($item->id)}}" data-toggle="modal">
                                <button class="btn theme-btn">{{__('Cancel Trade')}}</button>
                            </a>
                        </li>
                        <div id="cancel_{{($item->id)}}" class="modal fade delete" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header"><h6 class="modal-title">{{__('Cancel')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                    <div class="modal-body">
                                        <p>{{__('Do you want to cancel order ?')}}</p>
                                        <form action="{{route('tradeCancel')}}" method="POST" enctype="multipart/form-data"
                                              id="">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{encrypt($item->id)}}">
                                            <input type="hidden" name="type" value="{{BUYER}}">
                                            <div class="cp-user-payment-type">
                                                <h3>{{__('Reason')}} </h3>
                                                <textarea name="reason" required class="form-control"></textarea>
                                            </div>
                                            <button type="submit" class=" mt-4 btn theme-btn">{{__('Submit')}}</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($item->status == TRADE_STATUS_ESCROW)
                        <li class="deleteuser mr-3">
                            <a title="{{__('Upload Payment Slip')}}" href="#upload_{{($item->id)}}" data-toggle="modal">
                                <button class="btn theme-btn">{{__('Upload Payment Slip')}}</button>
                            </a>
                        </li>
                        <div id="upload_{{($item->id)}}" class="modal fade delete" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header"><h6 class="modal-title">{{__('Upload Payment Slip')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                    <div class="modal-body">
                                        <p>{{__('If your payment has done then upload your Payment Slip')}}</p>
                                        <form action="{{route('uploadPaymentSleep')}}" method="POST" enctype="multipart/form-data"
                                              id="">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{encrypt($item->id)}}">
                                            <div class="cp-user-payment-type">
                                                <h3>{{__('Payment Slip ')}} </h3>
                                                <div id="file-upload" class="section-p">
                                                    <input type="file" placeholder="0.00" required name="payment_sleep" value=""
                                                           id="file" ref="file" class="dropify" />
                                                </div>
                                            </div>

                                            <button type="submit" class=" mt-4 btn theme-btn">{{__('Upload')}}</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if($item->status != TRADE_STATUS_TRANSFER_DONE)
                    <li class="deleteuser mr-3">
                        <a title="{{__('Report User')}}" href="#report_{{($item->id)}}" data-toggle="modal">
                            <button class="btn theme-btn">{{__('Report User')}}</button>
                        </a>
                    </li>
                    <div id="report_{{($item->id)}}" class="modal fade delete" role="dialog">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header"><h6 class="modal-title">{{__('Report User')}}</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                <div class="modal-body">
                                    <p>{{__('Do you want to report this order ?')}}</p>
                                    <form action="{{route('reportUserOrder')}}" method="POST" enctype="multipart/form-data"
                                          id="">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{encrypt($item->id)}}">
                                        <input type="hidden" name="type" @if($type =='seller') value="{{SELLER}}" @else value="{{BUYER}}" @endif>
                                        <div class="cp-user-payment-type">
                                            <h3>{{__('Reason')}} </h3>
                                            <textarea name="reason"  class="form-control"></textarea>
                                        </div>
                                        <div class="cp-user-payment-type mt-3">
                                            <h3>{{__('Attachment (if any) ')}} </h3>
                                            <div id="file-upload" class="section-p">
                                                <input type="file" placeholder="0.00"  name="attach_file" value=""
                                                       id="file" ref="file" class="dropify" />
                                            </div>
                                        </div>
                                        <button type="submit" class=" mt-4 btn theme-btn">{{__('Submit')}}</button>
                                    </form>
                                </div>
                                <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </ul>
        @endif
    </div>
</div>
