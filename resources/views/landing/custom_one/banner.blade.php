<!-- hero banenr start here  -->
<style>
    .hero-banner-area {
        background-image: url('{{check_storage_image_exists($section_data[0]->image)}}');
    }
</style>

<div class="hero-banner-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">{{$section_parent->section_title}}</h1>
                <p class="hero-content">{{$section_parent->section_description}}</p>
                @if(Auth::user())
                    @if(Auth::user()->role == USER_ROLE_USER)
                        <a href="{{route('marketPlace')}}" class="primary-btn btn-md">{{__('Go The Marketplace')}}</a>
                    @else
                        <a href="{{route('adminDashboard')}}" class="primary-btn btn-md">{{__('Dashboard')}}</a>
                    @endif
                @else
                    <a class="primary-btn btn-md me-3" href="{{route('login')}}">{{$section_data[0]->login_button_name}}</a>
                    <a class="primary-btn btn-md" href="{{route('signUp')}}">{{$section_data[0]->register_button_name}}</a>
                @endif

            </div>
            @if($section_data[0]->is_filter)
                <div class="col-lg-5 offset-lg-1">
                <div class="find-offer-form">
                    <h3 class="form-title">find your offers</h3>
                    <form action="{{route('marketPlace')}}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="offer_type" class="form-select form-control">
                                        <option value="{{BUY_SELL}}">Buy/Sell</option>
                                        <option value="{{BUY}}">Buy</option>
                                        <option value="{{SELL}}">Sell</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="coin_type" class="form-select form-control">
                                        @foreach($coins as $coin)
                                            <option value="{{$coin->type}}" @if($coin->type==$coins_type) selected @endif>{{$coin->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="country" class="form-select form-control" id="country">
                                        <option value="any" @if('any'==$country) selected @endif>Any</option>
                                        @foreach($countries as $key=>$country_1)
                                            <option value="{{$key}}" @if($key==$country) selected @endif>{{$country_1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="payment_method" class="form-select form-control" id="payment_method">
                                        <option value="any" @if('any'==$pmethod) selected @endif>Any Payment Method</option>
                                        @foreach($payment_methods as $method)
                                            <option value="{{$method->id}}" @if($method->id==$pmethod) selected @endif>{{$method->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="primary-btn w-100">find offers</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
<!-- hero banner end here  -->
