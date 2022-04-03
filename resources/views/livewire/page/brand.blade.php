<div>
    
    <div class="container-fluid py-5">
        {{-- Banner --}}
        @livewire('custom-banner')
        
        <input type="search" class="form-control" wire:model="q" placeholder="Search product {{$name}}..." required>
        <hr>
        <div class="toolbox">
            <div class="toolbox-left">
                <div class="brand-filter">
                    Brand :
                    <a href="{{route('product')}}" style="cursor:pointer" class="product-cat px-3 {{$idbrand === null ? 'active' : ''}}">Semua</a>

                    @foreach ($brands as $brand)
                        <a href="{{route('product.brand',$brand->slug)}}" style="cursor:pointer" class="product-cat px-3 {{$idbrand === $brand->id ? 'active' : ''}}">{{$brand->name}}</a>
                    @endforeach
                </div>
            </div><!-- End .toolbox-left -->

            <div class="toolbox-center">
                <div class="toolbox-info">
                    Showing <span>{{$limit > $count ? $count : $limit}} of {{$count}}</span> Products
                </div><!-- End .toolbox-info -->
            </div><!-- End .toolbox-center -->

            <div class="toolbox-right">
                <div class="toolbox-sort">
                    <label for="sortby">Urut berdasarkan</label>
                    <div class="select-custom">
                        <select wire:model="sortby" id="sortby" class="form-control">
                            <option value="promo" selected="selected">Sedang Promo</option>
                            <option value="terbaru">Terbaru</option>
                            <option value="termahal">Harga Termahal</option>
                            <option value="termurah">Harga Termurah</option>
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
                            @if ($product->discount === 0 || $product->discount === '0')
                                <span></span>
                            @else
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
                                    <a href="{{$cat->slug}}">{{$cat->name}}</a>
                                @endforeach
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{route('product.show',$product->slug)}}">{{$product->name}}</a></h3><!-- End .product-title -->
                            @if ($product->preorder === 1)
                                <div class="my-2"><span class="p-1 rounded px-2 text-white bg-success">Preorder</span></div>
                            @endif
                            <div class="product-price">
                                <span class="new-price">{{Helper::rupiah(($product->discount !== 0 || $product->discount !== null) ? $product->price - $product->price*$product->discount/100 : $product->price)}}</span>
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
                <div class="text-center p-3 bg-light">
                    Ooooppsss... Tidak ada data untuk ditampilkan.
                    Silahkan masukan kata kunci lain atau <a href="{{route('product')}}">telusuri di semua brand</a>
                </div>
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
