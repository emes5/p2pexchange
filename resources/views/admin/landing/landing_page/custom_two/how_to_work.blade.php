<section class="how-work section-top mb-90">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title work-title-main">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title work-sub-title-main">{{$section_parent->section_description}}</p>
        </div>
        <ul class="nav nav-tabs" id="cryptoBuySellTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="buyCrypto-tab" data-bs-toggle="tab" data-bs-target="#buyCrypto" type="button" role="tab" aria-controls="buyCrypto" aria-selected="true">buy crypto</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sellCrypto-tab" data-bs-toggle="tab" data-bs-target="#sellCrypto" type="button" role="tab" aria-controls="sellCrypto" aria-selected="false">sell crypto</button>
            </li>
        </ul>
        <div class="tab-content" id="cryptoBuySellTabContent">
            <div class="tab-pane fade show active" id="buyCrypto" role="tabpanel" aria-labelledby="buyCrypto-tab">
                <div class="row work-details-container-buy">
                    @foreach($section_data as $details)
                        @if($details->type==1)
                        <div class="col-lg-4 col-md-6 work-details-view-{{$details->id}}">
                            <div class="single-work">
                                <img class="work-icon" src="{{check_storage_image_exists($details->image)}}" alt="work-icon" />
                                <h3 class="work-title">{{$details->sub_title}}</h3>
                                <p class="work-content">{{$details->sub_description}}</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="sellCrypto" role="tabpanel" aria-labelledby="sellCrypto-tab">
                <div class="row work-details-container-sell">
                    @foreach($section_data as $details)
                        @if($details->type==2)
                        <div class="col-lg-4 col-md-6 work-details-view-{{$details->id}}">
                            <div class="single-work">
                                <img class="work-icon" src="{{check_storage_image_exists($details->image)}}" alt="work-icon" />
                                <h3 class="work-title">{{$details->sub_title}}</h3>
                                <p class="work-content">{{$details->sub_description}}</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
