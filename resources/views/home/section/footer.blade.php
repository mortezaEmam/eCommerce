<footer class="footer-area bg-paleturquoise" style="direction: rtl;">
    <div class="container">
        <div class="footer-top text-center pt-45 pb-45">
            <nav>
                <ul>
                    <li><a href="{{route('home.index')}}">صفحه ای اصلی </a></li>
                    <li><a href="{{route('home.index')}}">فروشگاه </a></li>
                    <li><a href="{{route('home.contact-us')}}">تماس با ما </a></li>
                    <li><a href="{{route('home.about-us')}}">ارتباط با ما </a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="footer-bottom border-top-1 pt-20">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="footer-social pb-20">
                        @if(isset($setting->instagram))
                            <div class="contact-info-icon">
                                <a href="{{$setting->instagram}}" target="_blank">
                                    <i class="sli sli-social-instagram"></i>
                                </a>
                            </div>
                        @endif
                        @if(isset($setting->facebook))
                            <div class="contact-info-icon">
                                <a href="{{$setting->facebook}}" target="_blank">
                                    <i class="sli sli-social-facebook"></i>
                                </a>
                            </div>
                        @endif
                        @if(isset($setting->github))
                            <div class="contact-info-icon">
                                <a href="{{$setting->github}}" target="_blank">
                                    <i class="sli sli-social-github"></i>
                                </a>
                            </div>
                        @endif
                        @if(isset($setting->telegram))
                            <div class="contact-info-icon">
                                <a href="{{$setting->telegram }}" target="_blank">
                                    <i class="sli sli-social-tumblr"></i>
                                </a>

                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="copyright text-center pb-20">
                        <p>Copyright © WebProg.ir</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-3 col-12">
                    <div class="payment-mathod pb-20">
                        <a href="#"><img src="assets/img/icon-img/payment.png" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
