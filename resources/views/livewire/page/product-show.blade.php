<div>
    @push('style')
    <link rel="stylesheet" href="/assets/css/plugins/nouislider/nouislider.css">
    @endpush
    @if (session()->has('failed'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{  session('failed') }}<a href="{{route('cart')}}" class="btn-primary p-3 ml-3">Lihat keranjang</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @elseif (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{  session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0 py-4">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('product')}}">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>

            <nav class="product-pager ml-auto" aria-label="Product">
                @if (isset($prev->slug))
                <a class="product-pager-link product-pager-prev" href="{{route('product.show',$prev->slug)}}" aria-label="Previous" tabindex="-1">
                    <i class="icon-angle-left"></i>
                    <span>Prev</span>
                </a>
                @endif
                @if (isset($next->slug))
                <a class="product-pager-link product-pager-next" href="{{route('product.show',$next->slug)}}" aria-label="Next" tabindex="-1">
                    <span>Next</span>
                    <i class="icon-angle-right"></i>
                </a>
                @endif
            </nav><!-- End .pager-nav -->
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <img id="product-zoom" src="{{asset('storage'.json_decode($product->image)[0])}}" data-zoom-image="{{asset('storage'.json_decode($product->image)[0])}}" alt="{{$product->name}} image">

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery position-relative" style="position: relative;">
                                    @foreach (json_decode($product->image) as $index=>$image)
                                        <a class="product-gallery-item {{$index === 0 ? 'active':''}}" href="#" data-image="{{asset('storage'.$image)}}" data-zoom-image="{{asset('storage'.$image)}}">
                                            <img src="{{asset('storage'.$image)}}" alt="{{$product->name}} image">
                                        </a>
                                    @endforeach
                                </div><!-- End .product-image-gallery -->
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title">{{ $product->name }}</h1><!-- End .product-title -->
                            @if ($product->preorder === 1)
                                <div class="my-2"><span class="p-1 rounded px-2 text-white bg-success">Preorder</span></div>
                            @endif
                            <div class="product-price">
                                <span class="new-price">{{Helper::rupiah(($product->discount !== 0 && $product->discount !== null) ? $product->price - $product->price*$product->discount/100 : $product->price)}}</span>
                                @if ($product->discount !== 0 && $product->discount !== null)
                                    <span class="old-price">{{Helper::rupiah($product->price)}}</span>
                                @endif
                            </div><!-- End .product-price -->

                            <div class="product-content">
                                <img src="{{asset('storage'.$product->brand->image)}}" alt="{{$product->brand->name}} brand" class="d-block" style="max-height:4em;">
                                <p>{{$product->brief}}</p>
                            </div><!-- End .product-content -->

                            <div class="details-filter-row details-row-size">
                                <label for="size">Variant:</label>
                                <div class="select-custom">
                                    <select wire:model="variant" id="size" class="form-control">
                                        <option value="unselect" selected="selected">Pilih variant</option>
                                        @foreach (json_decode($product->variant) as $variant)
                                        <option value="{{$variant}}">{{$variant}}</option>
                                        @endforeach
                                    </select>
                                    @error('variant') <small class="text-danger">{{$message}}</small> @enderror
                                </div><!-- End .select-custom -->

                                <label for="size">Size:</label>
                                <div class="select-custom">
                                    <select wire:model="size" id="size" class="form-control">
                                        <option value="unselect" selected="selected">Pilih Size</option>
                                        @foreach (json_decode($product->size) as $size)
                                            <option value="{{$size}}">{{$size}}</option>
                                        @endforeach
                                    </select>
                                    @error('variant') <small class="text-danger">{{$message}}</small> @enderror
                                </div><!-- End .select-custom -->
                            </div><!-- End .details-filter-row -->
                            
                            <div class="details-filter-row details-row-size">
                                @if ($product->preorder === 1)
                                    <label for="qty">Qty Preorder:</label>
                                @else
                                    <label for="qty">Qty:</label>
                                @endif
                                <div class="product-details-quantity">
                                    <input wire:model="qty" type="number" class="form-control" value="1" min="1" max="{{$product->stock}}" step="1" data-decimals="0" required>
                                </div><!-- End .product-details-quantity -->
                            </div><!-- End .details-filter-row -->

                            <div class="product-details-action" style="width: 100%;">
                                <div class="w-100 d-block mb-1" wire:click="buyWA"><a href="#" class="btn btn-primary w-100 py-4" style="max-width: 90em;"><span class="iconify mr-3" data-icon="akar-icons:whatsapp-fill"></span><span>Beli melalui Whatsapp</span></a></div>
                                <a wire:click="addCart({{$product->id}})" class="btn-product btn-cart w-100" style="max-width: 90em; cursor:pointer"><span>add to cart</span></a>
                            </div><!-- End .product-details-action -->

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    @if (count($product->categories) > 0)
                                        @foreach ($product->categories as $cat)
                                            <a href="{{route('product.category',$cat->slug)}}">{{$cat->name}}</a>
                                        @endforeach 
                                    @else
                                        -
                                    @endif                                   
                                </div><!-- End .product-cat -->

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                </div>
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            {!! $product->desc   !!}
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <h2 class="title text-center mb-4">Kamu Mungkin Juga Suka</h2><!-- End .title text-center -->

            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": false, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":5,
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>
                @forelse ($products as $product)
                <div class="product">
                    <figure class="product-media">
                        <span class="product-label label-new" style="background-color: {{$product->label->bg_color}} !important">{{$product->label->name}}</span>
                        @if ($product->discount !== null && $product->discount !== 0)
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
                @empty
                <div class="text-center p-4">Tidak ada data products</div>
                @endforelse
            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->

    @push('script')
    <script src="/assets/js/jquery.elevateZoom.min.js"></script>
    @endpush
</div>
