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
                    <a href="#" class="primary-btn-two register_button_name">{{$section_data[0]->register_button_name}}</a>
                </div>
            </div>
            <div class="col-lg-6">
                @if($section_data[0]->is_filter)
                    <div class="hero-form find-offer-div">
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
                                <div class="form-group">
                                    <label>buy</label>
                                    <select class="form-select form-control">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>payment method</label>
                                    <select class="form-select form-control">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>i want to spend</label>
                                    <select class="form-select form-control">
                                        <option></option>
                                    </select>
                                </div>
                                <button type="button" class="primary-btn-two">find offer</button>
                        </div>
                        <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                                <div class="form-group">
                                    <label>sell</label>
                                    <select class="form-select form-control">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select class="form-select form-control">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>i want to spend</label>
                                    <select class="form-select form-control">
                                        <option></option>
                                    </select>
                                </div>
                                <button type="button" class="primary-btn-two">find offers</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
