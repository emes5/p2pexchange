<div class="card cp-user-custom-card">
    <div class="card-body">
        <div class="cp-user-card-header-area cp-user-card-header-bb">
            <h4>{{__('Invite Your Contact')}}</h4>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="cp-user-referral-content">
                    <div class="form-group">
                        <h4 class="cp-user-share-title">{{__('Share This Link to Your Contact')}}</h4>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button onclick="CopyUrl()" type="button" class="btn copy-url-btn">{{__('Copy URL')}}</button>
                            </div>
                            <input type="url" class="form-control" id="url" value="{{ $url }}" readonly>
                        </div>
                    </div>
                    <div class="cp-user-content-bottom">
                        <span class="cp-user-share-title">or</span>
                        <h4 class="cp-user-share-title">{{__('Share Your Code On')}}</h4>
                        <div class="cp-user-share-buttons">
                            <ul>
                                <li><a class="fb" href="https://www.facebook.com/sharer/sharer.php?u={{$url}}" target="_blank"><i class="fa fa-facebook"></i> {{__('Facebook')}}</a></li>
                                <li><a class="twit" target="_blank" href="http://www.twitter.com/share?url={{$url}}"><i class="fa fa-twitter"></i> {{__('Twitter')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
