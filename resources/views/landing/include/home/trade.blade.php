<section class="how-to-trade" id="how-to-trade">
    <article class="trading-coins">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 wow animate__fadeInUp"
                     data-wow-duration="{{rand(4,7)}}00ms">
                    <div class="coin-card">
                        <div class="icon">
                            <img src="{{asset('assets/landing/master/images/coins/1.png')}}"  class="img-fluid" alt="">
                        </div>
                        <h3></h3>
                        <p>{{__('Fusce dui erat, efficitur ac
                                        nibh eget, tristique lobortis erat. Duiset luctus eleifend
                                        elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque
                                        penatibus et
                                        magnis dis parturient montes, nascetur ridiculus mus.')}} </p>
                        <div class="btn-group">
                            <a href="{{route('marketPlace')}}"
                               class="btn buy-sale-btn buy-sale-btn-1">{{__('Buy')}}</a>
                            <a href="{{route('marketPlace')}}" class="btn buy-sale-btn buy-sale-btn-2">Sell</a>
                        </div>
                    </div>
                </div>
                    <div class="col-lg-6 mb-4 wow animate__fadeInUp" data-wow-duration="300ms">
                        <div class="coin-card">
                            <div class="icon">
                                <img src="{{asset('assets/landing/master/images/coins/1.png')}}" class="img-fluid" alt="">
                            </div>
                            <h3>Bitcoin</h3>
                            <p>Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus
                                eleifend
                                elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus
                                et
                                magnis dis parturient montes, nascetur ridiculus mus.</p>
                            <div class="btn-group">
                                <a href="void:" class="btn buy-sale-btn buy-sale-btn-1">Buy</a>
                                <a href="void:" class="btn buy-sale-btn buy-sale-btn-2">Sell</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 wow animate__fadeInUp" data-wow-duration="500ms">
                        <div class="coin-card">
                            <div class="icon">
                                <img src="{{asset('assets/landing/master/images/coins/2.png')}}" class="img-fluid" alt="">
                            </div>
                            <h3>Ethereum</h3>
                            <p>Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus
                                eleifend
                                elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus
                                et
                                magnis dis parturient montes, nascetur ridiculus mus.</p>
                            <div class="btn-group">
                                <a href="void:" class="btn buy-sale-btn buy-sale-btn-1">Buy</a>
                                <a href="void:" class="btn buy-sale-btn buy-sale-btn-2">Sell</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 wow animate__fadeInUp" data-wow-duration="300ms">
                        <div class="coin-card">
                            <div class="icon">
                                <img src="{{asset('assets/landing/master/images/coins/3.png')}}" class="img-fluid" alt="">
                            </div>
                            <h3>Litecoin</h3>
                            <p>Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus
                                eleifend
                                elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus
                                et
                                magnis dis parturient montes, nascetur ridiculus mus.</p>
                            <div class="btn-group">
                                <a href="void:" class="btn buy-sale-btn buy-sale-btn-1">Buy</a>
                                <a href="void:" class="btn buy-sale-btn buy-sale-btn-2">Sell</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 wow animate__fadeInUp" data-wow-duration="500ms">
                        <div class="coin-card">
                            <div class="icon">
                                <img src="{{asset('assets/landing/master/images/coins/4.png')}}" class="img-fluid" alt="">
                            </div>
                            <h3>Bitcoin</h3>
                            <p>Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus
                                eleifend
                                elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus
                                et
                                magnis dis parturient montes, nascetur ridiculus mus.</p>
                            <div class="btn-group">
                                <a href="void:" class="btn buy-sale-btn buy-sale-btn-1">Buy</a>
                                <a href="void:" class="btn buy-sale-btn buy-sale-btn-2">Sell</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </article>
    <article class="treading-process">
        <div class="arrow arrow-top wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/top-arrow.png')}}" class="img-fluid" alt="">
        </div>
        <div class="arrow arrow-bottom wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/bottom-arrow.png')}}" class="img-fluid" alt="">
        </div>
        <div class="arrow arrow-left wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/left-side-arrow.png')}}" class="img-fluid" alt="">
        </div>
        <div class="arrow arrow-right wow animate__fadeIn" data-wow-duration="500ms">
            <img src="{{asset('assets/landing/master/images/right-side-arrow.png')}}" class="img-fluid" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="wow animate__fadeInUp"
                            data-wow-duration="500ms"> {!! isset($settings['trade_section_title']) ? clean($settings['trade_section_title']) : 'How To Do Pexeer Trading' !!} </h2>
                        <p class="wow animate__fadeInUp" data-wow-duration="700ms">
                            {!! isset($settings['trade_section_des']) ? clean($settings['trade_section_des']) : 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque
                            mauris sit amet dignissim.' !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6 mb-5 wow animate__fadeInUp" data-wow-duration="1s">
                    <div class="treading-process-card">
                        <img
                            @if(isset($settings['trade_process_four_img'])) src="{{asset(path_image().$settings['trade_process_four_img'])}}"
                            @else
                            src="{{asset('assets/landing/master/images/tread-process/1.png')}}" @endif class="img-fluid"
                            alt="">
                        <div class="content">
                            <h4 class="mt-4">
                                4.{!! isset($settings['trade_process_four_title']) ? clean($settings['trade_process_four_title']) : 'Make Exchange' !!} </h4>
                            <p> {!! isset($settings['trade_process_four_des']) ? clean($settings['trade_process_four_des']) : 'Donec tristique commodo massa, prtiu egestas metus luctus eu.' !!}  </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5 wow animate__fadeInUp" data-wow-duration="500ms">
                    <div class="treading-process-card">
                        <img
                            @if(isset($settings['trade_process_one_img'])) src="{{asset(path_image().$settings['trade_process_one_img'])}}"
                            @else
                            src="{{asset('assets/landing/master/images/tread-process/2.png')}}" @endif class="img-fluid"
                            alt="">
                        <div class="content">
                            <h4 class="mt-4">
                                1.{!! isset($settings['trade_process_one_title']) ? clean($settings['trade_process_one_title']) : 'Create account' !!}</h4>
                            <p> {!! isset($settings['trade_process_one_des']) ? clean($settings['trade_process_one_des']) : 'Donec tristique commodo massa, prtiu egestas metus luctus eu.' !!}  </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow animate__fadeInUp" data-wow-duration="700ms">
                    <div class="treading-process-card">
                        <div class="content">
                            <h4>
                                3.{!! isset($settings['trade_process_three_title']) ? clean($settings['trade_process_three_title']) : 'Open Trade' !!}</h4>
                            <p class="mb-4"> {!! isset($settings['trade_process_three_des']) ? clean($settings['trade_process_three_des']) : 'Donec tristique commodo massa, prtiu egestas metus luctus eu.' !!} </p>
                        </div>
                        <img
                            @if(isset($settings['trade_process_three_img'])) src="{{asset(path_image().$settings['trade_process_three_img'])}}"
                            @else
                            src="{{asset('assets/landing/master/images/tread-process/3.png')}}" @endif class="img-fluid"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-6 wow animate__fadeInUp" data-wow-duration="900ms">
                    <div class="treading-process-card">
                        <div class="content">
                            <h4>
                                2.{!! isset($settings['trade_process_two_title']) ? clean($settings['trade_process_two_title']) : 'Watch Buy And Selling' !!}</h4>
                            <p class="mb-4">{!! isset($settings['trade_process_two_des']) ? clean($settings['trade_process_two_des']) : 'Donec tristique commodo massa, prtiu egestas metus luctus eu.' !!} </p>
                        </div>
                        <img
                            @if(isset($settings['trade_process_two_img'])) src="{{asset(path_image().$settings['trade_process_two_img'])}}"
                            @else
                            src="{{asset('assets/landing/master/images/tread-process/4.png')}}" @endif class="img-fluid"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
