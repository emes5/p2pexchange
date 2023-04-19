<!-- hero banenr start here  -->

@if(!empty($section_data[0]->image))
    <style>
        .hero-banner-area{{$element_prefix}} {
            background-image: url('{{check_storage_image_exists($section_data[0]->image)}}');
        }
    </style>
@endif

<div class="hero-banner-area{{$element_prefix}}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-banner-info">
                    <h1 class="hero-title">{{$section_parent->section_title}}</h1>
                    <p class="hero-content">{{$section_parent->section_description}}</p>

                    @if(Auth::user())
                        @if(Auth::user()->role == USER_ROLE_USER)
                            <a href="{{route('marketPlace')}}" class="primary-btn-two">{{__('Go The Marketplace')}}</a>
                        @else
                            <a href="{{route('adminDashboard')}}" class="primary-btn-two">{{__('Dashboard')}}</a>
                        @endif
                    @else
                        <a href="{{route('signUp')}}" class="primary-btn-two">{{$section_data[0]->register_button_name}}</a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                @if($section_data[0]->is_filter)
                    <div class="hero-form">
                    <ul class="nav nav-tabs buy-sell-tab" id="buySellTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab" aria-controls="buy" aria-selected="true">Buy</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sell-tab" data-bs-toggle="tab" data-bs-target="#sell" type="button" role="tab" aria-controls="sell" aria-selected="false">Sell</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="buySellTabContent">
                        <div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="buy-tab">
                            <form action="{{route('marketPlace')}}" method="GET">
                                <div class="form-group">
                                    <label>Buy</label>
                                    <input type="hidden" name="offer_type" value="{{BUY}}">
                                    <select name="coin_type" class="form-select form-control">
                                        @foreach($coins as $coin)
                                            <option value="{{$coin->type}}" @if($coin->type==$coins_type) selected @endif>{{$coin->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select name="payment_method" class="form-select form-control" id="payment_method">
                                        <option value="any" @if('any'==$pmethod) selected @endif>Any Payment Method</option>
                                        @foreach($payment_methods as $method)
                                            <option value="{{$method->id}}" @if($method->id==$pmethod) selected @endif>{{$method->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Choose Country</label>
                                    <select name="country" class="form-select form-control" id="country">
                                        <option value="any" @if('any'==$country) selected @endif>Any</option>
                                        @foreach($countries as $key=>$country_1)
                                            <option value="{{$key}}" @if($key==$country) selected @endif>{{$country_1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="primary-btn-two">find offer</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                            <form action="{{route('marketPlace')}}" method="GET">
                                <div class="form-group">
                                    <label>Sell</label>
                                    <input type="hidden" name="offer_type" value="{{SELL}}">
                                    <select name="coin_type" class="form-select form-control">
                                        @foreach($coins as $coin)
                                            <option value="{{$coin->type}}" @if($coin->type==$coins_type) selected @endif>{{$coin->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select name="payment_method" class="form-select form-control">
                                        <option value="any" @if('any'==$pmethod) selected @endif>Any Payment Method</option>
                                        @foreach($payment_methods as $method)
                                            <option value="{{$method->id}}" @if($method->id==$pmethod) selected @endif>{{$method->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Choose Country</label>
                                    <select name="country" class="form-select form-control">
                                        <option value="any" @if('any'==$country) selected @endif>Any</option>
                                        @foreach($countries as $key=>$country_1)
                                            <option value="{{$key}}" @if($key==$country) selected @endif>{{$country_1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="primary-btn-two">find offer</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
