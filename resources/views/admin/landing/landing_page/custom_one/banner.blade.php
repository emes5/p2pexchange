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
                <a class="primary-btn btn-md me-3 login_button_name" href="#">{{$section_data[0]->login_button_name}}</a>
                <a class="primary-btn btn-md register_button_name" href="#">{{$section_data[0]->register_button_name}}</a>
            </div>
            @if($section_data[0]->is_filter)
                <div class="col-lg-5 offset-lg-1 find-offer-div">
                    <div class="find-offer-form">
                    <h3 class="form-title">find your offers</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-select form-control">
                                    <option selected>Select Buy or Sell</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-select form-control">
                                    <option selected>Select Crypto Currency</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-select form-control">
                                    <option selected>Select Payment Method</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-select form-control">
                                    <option selected>Select ONe</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="preferred-amount" placeholder="Preferred Amount (optional)" />
                            </div>
                            <button type="button" class="primary-btn w-100">find offers</button>
                        </div>
                    </div>
                </div>
                </div>
            @endif

        </div>
    </div>
</div>
<!-- hero banner end here  -->
