    <div class="header-right">

        <div class="header-search header-search-extended header-search-visible">
            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
            <form wire:submit.prevent="search" method="get">
                <div class="header-search-wrapper search-wrapper-wide">
                    <label for="q" class="sr-only">Search</label>
                    <input type="search" class="form-control" wire:model="q" id="q" placeholder="Search product ..." required>
                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                </div><!-- End .header-search-wrapper -->
            </form>
        </div><!-- End .header-search -->
        
        @guest
        <div class="dropdown cart-dropdown">
            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                <i class="icon-shopping-cart"></i>
                <span class="cart-count">0</span>
            </a>
        </div><!-- End .cart-dropdown -->
        @else
        <div class="dropdown cart-dropdown">
            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                <i class="icon-shopping-cart"></i>
                <span class="cart-count">{{$carts['count']}}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-cart-products" style="overflow-x: auto;max-height:25em; ">
                    @forelse ($carts['data'] as $cart)
                    <div class="border-bottom">
                        <div class="product border-0 py-0 pt-1">
                            <div class="product-cart-details">
                                <h4 class="product-title">
                                    <a href="{{route('product.show',$cart->product->slug)}}">{{$cart->product->name}} <br> <strong>{{json_decode($cart->detail)->size}} - {{json_decode($cart->detail)->variant}}</strong></a>
                                </h4>
                            </div><!-- End .product-cart-details -->
    
                            <figure class="product-image-container">
                                <a href="{{route('product.show',$cart->product->slug)}}" class="product-image">
                                    <img src="{{asset('storage'.json_decode($cart->product->image)[0])}}" alt="{{$cart->product->name}}">
                                </a>
                            </figure>
                            
                            <a wire:click="delCart({{$cart->id}})" class="btn-remove" style="cursor: pointer" title="Remove Product"><i class="icon-close"></i></a>
                        </div><!-- End .product -->
                        <div class="cart-product-info d-flex align-items-center justify-content-between w-100">
                            <div class="cart-product-quantity d-flex align-items-center">
                                <div wire:click="delQty({{$cart->id}})" class="btn-light text-center" style="width: 2em;height:2em;cursor:pointer;">-</div>
                                <div class="text-decoration-underline p-4">{{$cart->qty}}</div>
                                <div wire:click="addQty({{$cart->id}})" class="btn-primary text-center" style="width: 2em;height:2em;cursor:pointer;">+</div>
                            </div><!-- End .cart-product-quantity -->
                            <div> x {{Helper::rupiah($cart->product->price - $cart->product->price*$cart->product->discount/100)}}</div>
                        </div>
                    </div>
                    @empty
                        <div class="text-center">Waah.. Keranjangnya kosong, Ayo berbelanja!</div>
                    @endforelse

                </div><!-- End .cart-product -->

                <div class="dropdown-cart-total">
                    <span>Total</span>
                    <span class="cart-total-price">{{Helper::rupiah($carts['total'])}}</span>
                </div><!-- End .dropdown-cart-total -->
                <div class="dropdown-cart-action">
                    <a href="{{route('cart')}}" class="btn btn-primary">View Cart</a>
                    <a href="{{route('cart')}}" class="btn btn-outline-primary-2">Checkout</a>
                </div><!-- End .dropdown-cart-total -->
            </div><!-- End .dropdown-menu -->
        </div><!-- End .cart-dropdown -->
        @endguest
        

        @guest()
            <div class="cart-dropdown">
                <a href="{{route('login')}}" class="dropdown-toggle">
                    <span class="iconify" data-icon="majesticons:user-line"></span>
                </a>
            </div><!-- End .cart-dropdown -->
        @else
            <div class="dropdown cart-dropdown">
                <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <img src="{{isset($user->image)?asset('storage/'.$user->image):'https://ui-avatars.com/api/?name='.$user->name.'&background=0D8ABC&color=fff'}}" alt="Foto {{$user->name}}" style="width: 1.4em;height: 1.4em;object-fit: cover;border-radius: 10px;">
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-cart-products">
                        @role('user')
                        <a href="{{route('profile')}}" class="text-dark py-4 d-flex align-items-center">
                            <span class="iconify mr-3" data-icon="bi:person-circle" style="width: 2em;height: 2em;"></span>
                            My Profile
                        </a><!-- End .product-cart-details -->
                        <a href="{{route('order.pending')}}" class="text-dark py-4 d-flex align-items-center">
                            <span class="iconify mr-3" data-icon="ic:outline-pending-actions" style="width: 2em;height: 2em;"></span>
                            Pesanan Pending
                            @if (count($ppndng) > 0 && $ppndng !== null)
                                <span class="cart-count">{{count($ppndng)}}</span>
                            @endif
                        </a><!-- End .product-cart-details -->
                        <a href="{{route('order.sukses')}}" class="text-dark py-4 d-flex align-items-center">
                            <span class="iconify mr-3" data-icon="icon-park-outline:transaction-order" style="width: 2em;height: 2em;"></span>
                            Transaksi Success
                        </a><!-- End .product-cart-details -->
                        @elserole('admin')
                        <a href="{{route('dash.index')}}" class="text-dark py-4 d-flex align-items-center">
                            <span class="iconify mr-3" data-icon="bxs:dashboard" style="width: 2em;height: 2em;"></span>
                            Dashboard
                        </a><!-- End .product-cart-details -->
                        @endrole
                        <a class="text-danger py-4 d-flex align-items-center" style="cursor: pointer" wire:click="logout">
                            <span class="iconify mr-3" data-icon="majesticons:logout" style="width: 2em;height: 2em;"></span>
                            Logout
                        </a>
                    </div>

                </div><!-- End .dropdown-menu -->
            </div><!-- End .cart-dropdown -->
        @endguest

    </div><!-- End .header-right -->
