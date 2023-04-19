<div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <div class="card-content">
                        <p>
                            @if(isset($settings['terms_condition']))
                                {!! $settings['terms_condition'] !!}
                            @else
                                "Lorem ipsum dolor sit amet, consectetur adipisicing elit. A animi distinctio dolore
                                ex, harum illum in inventore ipsam iusto laborum maiores minima minus modi nulla
                                odio odit pariatur porro quod ratione reiciendis rerum tempore velit veritatis!
                                Consequuntur corporis dolores ea eaque, error excepturi id ipsam iste magnam
                                Consequatur dolorem eos id illo numquam odit perspiciatis
                                recusandae repudiandae suscipit unde. Aliquam, amet aperiam consequuntur corporis
                                cum delectus dignissimos, ex, molestias obcaecati placeat quam quisquam quos rerum
                                temporibus ut veritatis voluptates? Dolore facilis illum impedit natus quae?
                                Accusantium adipisci asperiores atque cum delectus esse, eum ex illo in incidunt
                                minima molestiae natus nemo neque nisi odio officiis possimus provident quae quaerat
                                quas reiciendis rem repudiandae sint voluptas voluptate, voluptatem. Aspernatur,
                                harum mollitia necessitatibus porro sit suscipit unde? Animi deleniti ducimus ea,
                                eius harum ipsum magnam nesciunt officiis reiciendis vel! Aliquid atque deserunt
                                fugit laborum qui quisquam saepe sapiente sequi vero voluptate. Aliquam aliquid
                                consequatur culpa in incidunt odio quibusdam, temporibus voluptatibus. Alias aliquid
                                commodi labore placeat tempora! Ad aperiam consequuntur, deserunt dolore eligendi
                                "
                            @endif
                        </p>
                    </div>
                    <div class="border-top pt-4">
                        <p>Please read this terms and condition carefully. It is necessary that
                            you
                            read and understand the information</p>
                    </div>
                    <form class="mt-4" action="{{route('saveUserAgreement')}}" method="POST">
                        @csrf
                        <div class="form-check">
                            <input class="form-check-input d-none" type="radio" name="agree_terms"
                                   id="popupRadio1"
                                   value="{{AGREE}}">
                            <label class="form-check-label" for="popupRadio1">{{__('Understand and Agree')}}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input d-none" type="radio" name="agree_terms"
                                   id="popupRadio2"
                                   value="{{NOT_AGREE}}">
                            <label class="form-check-label" for="popupRadio2">{{__('Not agree')}}</label>
                        </div>
                        <div class="form-group mt-4">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Close')}}</button>
                            <button type="submit" class="btn theme-btn">{{__('Continue')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
