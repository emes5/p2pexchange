<section class="how-to-trade-new" id="how-to-trade">
    <article class="trading-coins">
        <div class="container">
            <div class="row">
                @foreach($section_data as $item)
                    <div class="col-lg-6 mb-4 wow animate__fadeInUp coin-details-view-{{$item->id}}" data-wow-duration="500ms">
                        <div class="coin-card">
                            <div class="icon">
                                <img src="{{show_image_path($item->image,'')}}" class="img-fluid" alt="">
                            </div>
                            <h3>{{$item->name}}</h3>
                            <p>{{$item->sub_description}}</p>
                            <div class="btn-group">
                                <a href="{{url("exchange?coin_type=$item->type")}}" class="btn buy-sale-btn buy-sale-btn-1">Buy</a>
                                <a href="{{url("exchange?coin_type=$item->type")}}" class="btn buy-sale-btn buy-sale-btn-2">Sell</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </article>
</section>
