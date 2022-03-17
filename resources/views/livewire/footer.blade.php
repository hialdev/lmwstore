<div>
    
    <footer class="footer bg-white">
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="widget widget-about">
                            <img src="/assets/images/lmw-logo.png" class="footer-logo" alt="Footer Logo" width="105" height="25">
                            <p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. </p>

                            <div class="social-icons">
                                <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                                <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                                <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                                <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
                                <a href="#" class="social-icon" target="_blank" title="Pinterest"><i class="icon-pinterest"></i></a>
                            </div><!-- End .soial-icons -->
                        </div><!-- End .widget about-widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->

                    <div class="col-sm-6 col-lg-4">
                        <div class="widget">
                            <h4 class="widget-title text-dark">Useful Links</h4><!-- End .widget-title -->

                            <ul class="widget-list">
                                <li><a href="http://langgengmakmurwijaya.com/">About LMW</a></li>
                                <li><a href="{{route('product')}}">Shop Now!</a></li>
                                <li><a href="{{route('faq')}}">FAQ</a></li>
                                <li><a href="{{route('contact')}}">Contact us</a></li>
                                <li><a href="{{route('login')}}">Log in</a></li>
                            </ul><!-- End .widget-list -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->

                    <div class="col-sm-6 col-lg-4">
                        <div class="widget">
                            <h4 class="widget-title text-dark">My Account</h4><!-- End .widget-title -->

                            <ul class="widget-list">
                                <li><a href="{{route('login')}}">Sign In</a></li>
                                <li><a href="{{route('cart')}}">View Cart</a></li>
                                <li><a href="{{route('order.pending')}}">Track My Order</a></li>
                                <li><a href="{{route('order.sukses')}}">My Success Order</a></li>
                                <li><a href="{{route('contact')}}">Help</a></li>
                            </ul><!-- End .widget-list -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .footer-middle -->

        <div class="footer-bottom">
            <div class="container">
                <p class="footer-copyright">Copyright © {{\Carbon\Carbon::now()->format('Y')}} LMW Store. All Rights Reserved.</p><!-- End .footer-copyright -->
            </div><!-- End .container -->
        </div><!-- End .footer-bottom -->
    </footer><!-- End .footer -->

</div>
