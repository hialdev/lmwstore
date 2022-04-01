<div>
    
    <div class="container-fluid py-5">
        <input type="search" class="form-control" name="q" placeholder="Search product ..." required>
        <hr>
        <div class="toolbox">
            <div class="toolbox-left">
                <div class="brand-filter">
                    Brand :
                    <a href="" class="product-cat px-3 active">Semua</a>
                    <a href="" class="product-cat px-3">ELEMWE</a>
                    <a href="" class="product-cat px-3">Batik Tambora</a>
                </div>
            </div><!-- End .toolbox-left -->

            <div class="toolbox-center">
                <div class="toolbox-info">
                    Showing <span>12 of 56</span> Products
                </div><!-- End .toolbox-info -->
            </div><!-- End .toolbox-center -->

            <div class="toolbox-right">
                <div class="toolbox-sort">
                    <label for="sortby">Urut berdasarkan</label>
                    <div class="select-custom">
                        <select name="sortby" id="sortby" class="form-control">
                            <option value="promo" selected="selected">Sedang Promo</option>
                            <option value="terbaru">Terbaru</option>
                            <option value="termurah">Harga Termurah</option>
                            <option value="termahal">Harga Termahal</option>
                        </select>
                    </div>
                </div><!-- End .toolbox-sort -->
            </div><!-- End .toolbox-right -->
        </div><!-- End .toolbox -->
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
                            
                            <a href="{{$product->id}}">
                                <img src="{{asset('storage'.$images[0])}}" alt="Product image" class="product-image">
                                <img src="{{asset('storage'.$images[1])}}" alt="Product image" class="product-image-hover">
                            </a>
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                @foreach ($product->categories as $cat)
                                    <a href="{{$cat->slug}}">{{$cat->name}}</a>
                                @endforeach
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{$product->id}}">{{$product->name}}</a></h3><!-- End .product-title -->
                            <div class="product-price">
                                {{Helper::rupiah($product->price)}}
                            </div><!-- End .product-price -->
                            <div style="max-width: 6em;">
                                <img src="{{asset('storage'.$product->brand->image)}}" alt="{{$product->brand->name}}" class="w-100">
                            </div>
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                @empty
                    
                @endforelse

            </div><!-- End .row -->

            @if ($count > $limit)
                <div class="load-more-container text-center">
                    <button wire:click="more" class="btn btn-outline-darker btn-load-more">More Products <i class="icon-refresh"></i></button>
                </div><!-- End .load-more-container -->
            @endif
        </div><!-- End .products -->
    </div>

</div>
