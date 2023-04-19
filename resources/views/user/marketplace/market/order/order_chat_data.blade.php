<div class="messages-box-right">
    @if(isset($selected_user))
        <div class="online-active">
            <div class="row">
                <div class="col-sm-12">
                    <div class="user-area">
                        <div class="user-img">
                            <a href="#"><img src="{{ show_image($selected_user->id,'user') }}"  alt="">
                            </a>
                        </div>
                        <div class="user-name">
                            <h5><a href="#">{{ $selected_user->username  }}</a></h5>
                            @if($selected_user->online_status == 'online')
                                <span class="text-success">{{__('Online')}}</span>
                            @else
                                <small class="text-secondary">{{__('Offline')}}</small>
                            @endif
                            <p>{{__('Last seen ')}}{{$selected_user->last_seen}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="messages-box">
        <div class="inner-message">
            @if(!empty($chat_list))
                <ul id="messageData">
                    @foreach($chat_list as $text)
                        <li class="{{ ($text->sender_id == Auth::user()->id) ? 'message-sent' : 'messages-resived' }} single-message">
                            @if($text->sender_id == Auth::user()->id)
                                @if(!empty($text->message))
                                    <div class="msg">
                                        <p>{{ $text->message }}  </p>
                                        <small>{{ $text->time }}</small>
                                    </div>
                                @endif
                                @if(isset($text->file[0]))
                                    <div class="msg-file">
                                        {!! $text->file[4] !!}
                                        <small>{{ $text->time }}</small>
                                    </div>
                                @endif
                            @endif
                            <div class="user-img">
                                <img
                                    @if(isset($text->sender_id))
                                        src="{{show_image($text->sender_id,'user')}}"
                                    @endif

                                    @if(isset($text->receiver_id))
                                        src="{{show_image($text->receiver_id,'user')}}"
                                    @endif  alt="">
                            </div>
                            @if($text->receiver_id == Auth::user()->id)
                                @if(!empty($text->message))
                                    <div class="msg">
                                        <p>{{ $text->message }}  </p>
                                        <small>{{ $text->time }}</small>
                                    </div>
                                @endif
                                @if(isset($text->file[0]))
                                    <div class="msg-file">
                                        {!! $text->file[4] !!}
                                        <small>{{ $text->time }}</small>
                                    </div>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    @if(isset($selected_user))
        <div class="text-messages-area">
            <Form id ="idForm" method="POST" enctype="multipart/form-data">
                <div class="preview_img_b_u d-none">
                    <img id="preview-image-before-upload" src="" alt="">
                    <span id="close_img" class="close-item"><i class="fa fa-times-circle" ></i></span>
                </div>
                <div class="alert alert-danger myalert" id="notification_box" style="display:none"></div>
                <div class="text-messages-inner">
                    <div class="form-group">
                        <input type="hidden" id="receiverId" name="receiver_id" @if(isset($selected_user)) value="{{encrypt($selected_user->id)}}" @endif>
                        <label class="upload-file-btn press-enter">
                            <span class="fa fa-paperclip press-enter"></span>
                            <input id="msgFile" type="file" class="upload-attachment press-enter" name="file" accept="image/*, .txt, .rar, .zip" />
                        </label>
                        <textarea name="message" id="textMessage">{{old('message')}}</textarea>
                    </div>
                    <div class="send-btn">
                        <button type="submit" id="submitButton" class="send">{{__('Send')}}</button>
                    </div>
                </div>
            </Form>
        </div>
    @endif
</div>
