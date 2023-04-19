<section class="subscribe-area section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="section-header-area text-center">
                    <h2 class="section-title">{{$section_parent->section_title}}</h2>
                    <p class="section-subtitle">{{$section_parent->section_description}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="subscribe-form">
                    <form action="{{route('subscriptionProcess')}}" method="post">
                        @csrf
                        <div class="subscribe-wrap">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" />
                            <button type="submit" class="send-btn"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
