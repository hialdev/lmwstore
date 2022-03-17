<div>
    
    <div class="icon-boxes-container bg-transparent">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-12 icon-boxes align-items-center">
                    @foreach ($values as $value)
                    <div class="col-sm-6 col-lg-4">
                        <div class="icon-box icon-box-side">
                            <span class="icon-box-icon">
                                <span class="iconify" data-icon="{{$value->icon}}"></span>
                            </span>

                            <div class="icon-box-content">
                                <h3 class="icon-box-title">{{$value->title}}</h3><!-- End .icon-box-title -->
                                <p>{{$value->desc}}</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-sm-6 col-lg-4 -->
                    @endforeach

                </div>
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .icon-boxes-container -->

</div>
