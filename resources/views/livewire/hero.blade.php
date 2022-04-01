<div>
    
    @if (count($banners) > 1)
    <div class="container-fluid">
        <div class="row">
            @for ($i=0;$i<2;$i++)
            <div class="col-lg-6">
                <div class="banner banner-big banner-overlay">
                    <a href="{{$banners[$i]->btn_url}}">
                        <img src="{{asset('storage'.$banners[$i]->image)}}" alt="{{$banners[$i]->title}}" style="height:24em;object-fit: cover">
                    </a>

                    <div class="banner-content banner-content-center">
                        <h3 class="banner-subtitle text-white">{{$banners[$i]->sub_title}}</h3><!-- End .banner-subtitle -->
                        <h2 class="banner-title text-white">{{$banners[$i]->title}}</h2><!-- End .banner-title -->
                        <a href="{{$banners[$i]->btn_url}}" class="btn underline"><span>{{$banners[$i]->btn_text}}</span></a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div><!-- End .col-lg-6 -->
            @endfor

        </div><!-- End .row -->
    @endif
    @if (count($banners) > 2)        
        <div class="row justify-content-center">
            @for ($i=2;$i<5;$i++)
            <div class="col-md-6 col-lg-4">
                <div class="banner banner-overlay text-white">
                    <a href="{{$banners[$i]->btn_url}}">
                        <img src="{{asset('storage'.$banners[$i]->image)}}" alt="{{$banners[$i]->title}}" style="height:20em;object-fit: cover">
                    </a>

                    <div class="banner-content {{$banners[$i]->position}}">
                        <h4 class="banner-subtitle">{{$banners[$i]->sub_title}}</h4><!-- End .banner-subtitle -->
                        <h3 class="banner-title">{{$banners[$i]->title}}</h3><!-- End .banner-title -->
                        <a href="{{$banners[$i]->url}}" class="btn underline btn-outline-white-3 banner-link">{{$banners[$i]->btn_text}}</a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div><!-- End .col-lg-4 -->
            @endfor
        </div><!-- End .row -->
    </div><!-- End .container-fluid -->
    @endif

</div>
