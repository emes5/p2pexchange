<section class="how-to-trade-area section" id="how-to-trade">
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
            @foreach($section_data as $item)
                <div class="col-lg-4 col-md-6 coin-details-view-{{$item->id}}">
                    <div class="single-trading-coin text-center">
                        <img class="trading-coin-image" src="{{show_image_path($item->image,'')}}" alt="trading-coin" />
                        <h3 class="trading-coin-title">{{$item->name}}</h3>
                        <p class="trading-coin-info">{{$item->sub_description}}</p>
                        <div class="buy-sell-area">
                            <a href="{{url("exchange?coin_type=$item->type")}}" class="primary-btn">{{__('buy')}}</a>
                            <a href="{{url("exchange?coin_type=$item->type")}}" class="primary-btn">{{__('sell')}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="marketplace-button mt-20 text-center">
            <a href="{{route('marketPlace')}}" class="primary-btn btn-lg">{{__('Go to Marketplace')}}<i class="fas fa-angle-right"></i></a>
        </div>
    </div>
</section>
