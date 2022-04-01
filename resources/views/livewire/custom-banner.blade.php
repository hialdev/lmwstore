<div class="row">
    <div class="col-12">
        <div class="banner banner-big">
            <a href="#">
                <img src="{{asset('storage'.$banner->image)}}" alt="{{$banner->title}} Banner" style="max-height: 30em;object-fit:cover">
            </a>

            <div class="banner-content" style="left: auto;margin-left:5%;">
                <h4 class="banner-subtitle text-primary">{{$banner->subtitle}}</h4><!-- End .banner-subtitle -->
                <h3 class="banner-title text-white">{{$banner->title}}</h3><!-- End .banner-title -->
                <p class="d-none d-lg-block">{{$banner->desc}}</p> 

                <a href="{{$banner->url}}" class="btn btn-primary btn-rounded"><span>{{$banner->btn_text}}</span><i class="icon-long-arrow-right"></i></a>
            </div><!-- End .banner-content -->
        </div><!-- End .banner -->
    </div><!-- End .col-12 -->
</div><!-- End .row -->