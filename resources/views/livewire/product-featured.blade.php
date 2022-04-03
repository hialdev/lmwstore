<div>
    
    <div class="bg-light-2 pt-6 pb-6 featured">
        <div class="container-fluid">
            <h2 class="title text-center mb-3">New Product!</h2><!-- End .title -->
            <hr>
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": false, 
                    "dots": false,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
                        },
                        "480": {
                            "items":2
                        },
                        "992": {
                            "items":3
                        },
                        "1200": {
                            "items":5
                        }
                    }
                }'>

                @forelse ($products as $product)
                <div class="product">
                    <figure class="product-media">
                        <span class="product-label label-new" style="background-color: {{$product->label->bg_color}} !important">{{$product->label->name}}</span>
                        @if ($product->discount === 0 || $product->discount === '0')
                            <span></span>
                        @else
                            <span class="product-label label-new bg-primary">-{{$product->discount}}%</span>
                        @endif
                        <a href="{{route('product.show',$product->slug)}}">
                            <img src="{{asset('storage'.json_decode($product->image)[0])}}" alt="Product image" class="product-image">
                            <img src="{{asset('storage'.json_decode($product->image)[1])}}" alt="Product image" class="product-image-hover">
                        </a>
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            @foreach ($product->categories as $cat)
                                <a href="{{$cat->slug}}">{{$cat->name}}</a>
                            @endforeach
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{route('product.show',$product->slug)}}">{{$product->name}}</a></h3><!-- End .product-title -->
                        @if ($product->preorder === 1)
                            <div class="my-2"><span class="p-1 rounded px-2 text-white bg-success">Preorder</span></div>
                        @endif
                        <div class="product-price">
                            <span class="new-price">{{Helper::rupiah(($product->discount !== 0 && $product->discount !== null) ? $product->price - $product->price*$product->discount/100 : $product->price)}}</span>
                            @if ($product->discount !== 0 && $product->discount !== null)
                                <span class="old-price">{{Helper::rupiah($product->price)}}</span>
                            @endif
                        </div><!-- End .product-price -->
                        <div style="max-width: 6em;">
                            <img src="{{asset('storage'.$product->brand->image)}}" alt="{{$product->name}}" class="w-100">
                        </div>
                    </div><!-- End .product-body -->
                </div><!-- End .product -->
                @empty
                <div class="text-center p-4">Tidak ada data products</div>
                @endforelse
                

            </div><!-- End .owl-carousel -->
        </div><!-- End .container-fluid -->
    </div><!-- End .bg-light-2 pt-4 pb-4 -->

</div>
