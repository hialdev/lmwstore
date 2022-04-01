<div>
    
    <footer class="footer bg-white">
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="widget widget-about">
                            <img src="{{$setting->get('logo_site') !== null? asset('storage'.$setting->get('logo_site')->content) :'/assets/images/lmw-logo.png'}}" class="footer-logo" alt="Footer Logo" width="105" height="25">
                            <p>{{$setting->get('desc_site')->content}}</p>

                            <div class="social-icons">
                                @foreach ($contacts as $c) 
                                    <a href="{{$c->url}}" class="social-icon" target="_blank" title="{{$c->platform}}"><span class="iconify" data-icon="{{$c->icon}}"></span></a>
                                @endforeach
                            </div><!-- End .soial-icons -->
                        </div><!-- End .widget about-widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->
                    @foreach ($footers as $foot)  
                    <div class="col-sm-6 col-lg-4">
                        <div class="widget">
                            <h4 class="widget-title text-dark">{{$foot->section}}</h4><!-- End .widget-title -->
                            
                            <ul class="widget-list">
                                @foreach ($foot->footer as $f)
                                <li><a href="{{url($f->foot_url)}}">{{$f->foot_text}}</a></li>
                                @endforeach
                            </ul><!-- End .widget-list -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->
                    @endforeach
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
