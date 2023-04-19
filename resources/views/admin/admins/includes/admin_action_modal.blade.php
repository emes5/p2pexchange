<div class="modal fade" id="userActionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userActionModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('userStatusAction')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <input type="hidden" name="action" id="action">
                    <div class="form-group">
                        <label for="message">{{__('Send Message to the user')}}</label>
                        <textarea class="form-control" rows="4" name="message"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
