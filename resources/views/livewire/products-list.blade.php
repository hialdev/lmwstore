<div>
    
    <div class="products">
        <div class="row">
            @forelse ($products as $product)
            @php
                $images = json_decode($product->image);
            @endphp
            <div class="col-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                <div class="product">
                    <figure class="product-media">
                        <span class="product-label label-new" style="background-color: {{$product->label->bg_color}} !important">{{$product->label->name}}</span>
                        @if ($product->discount !== null && $product->discount !== 0)
                            <span class="product-label label-new bg-primary">-{{$product->discount}}%</span>
                        @endif
                        <a href="{{route('product.show',$product->slug)}}">
                            <img src="{{asset('storage'.$images[0])}}" alt="Product image" class="product-image">
                            <img src="{{asset('storage'.$images[1])}}" alt="Product image" class="product-image-hover">
                        </a>
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            @foreach ($product->categories as $cat)
                                <a href="{{route('product.category',$cat->slug)}}">{{$cat->name}}</a>
                            @endforeach
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{route('product.show',$product->slug)}}">{{$product->name}}</a></h3><!-- End .product-title -->
                        <div class="product-price">
                            <span class="new-price">{{Helper::rupiah(($product->discount !== 0 && $product->discount !== null) ? $product->price - $product->price*$product->discount/100 : $product->price)}}</span>
                            @if ($product->discount !== 0 && $product->discount !== null)
                                <span class="old-price">{{Helper::rupiah($product->price)}}</span>
                            @endif
                        </div><!-- End .product-price -->
                        <div style="max-width: 6em;">
                            <img src="{{asset('storage'.$product->brand->image)}}" alt="{{$product->brand->name}}" class="w-100">
                        </div>
                    </div><!-- End .product-body -->
                </div><!-- End .product -->
            </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
            @empty
                <div class="text-center">Uupps maaf... Tidak ada data untuk ditampilkan.</div>
            @endforelse

        </div><!-- End .row -->

        <div class="load-more-container text-center">
            <a href="{{route('product')}}" class="btn btn-outline-darker btn-load-more">More Products <span class="iconify" data-icon="cil:arrow-right"></span></a>
        </div><!-- End .load-more-container -->
    </div><!-- End .products -->

</div>
