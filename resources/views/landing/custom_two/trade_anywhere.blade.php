<section class="tread-anywhare-area section">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title">{{$section_parent->section_description}}</p>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="trade-image">
                    <img src="{{check_storage_image_exists($section_data[0]->image_one)}}" alt="trade-image" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="scan-area">
                    <div class="scan-qr">
                        <img src="{{check_storage_image_exists($section_data[0]->image_two)}}" alt="qr" />
                    </div>
                    <div class="scan-text">
                        <h3>scan to download</h3>
                        <h4>ios & android</h4>
                    </div>
                </div>
                <div class="oprator-list">
                    <ul>
                        <li>
                            <a href="{{$section_data[0]->app_store_link}}">
                                <i class="fab fa-apple"></i>
                                <span>App Store</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{$section_data[0]->android_apk_link}}">
                                <i class="fab fa-android"></i>
                                <span>Android APK</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{$section_data[0]->play_store_link}}">
                                <i class="fab fa-google-play"></i>
                                <span>Google Play</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{$section_data[0]->windows_link}}">
                                <i class="fab fa-windows"></i>
                                <span>Windows</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{$section_data[0]->linux_link}}">
                                <i class="fab fa-linux"></i>
                                <span>Linux</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{$section_data[0]->mac_link}}">
                                <i class="fab fa-apple"></i>
                                <span>MacOS</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{$section_data[0]->api_link}}">
                                <i class="fas fa-plug"></i>
                                <span>api</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
