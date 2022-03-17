<div>
    @if (session()->has('failed'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{  session('failed') }}
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

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($cart['data'] as $cart)
                                <tr>
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="{{route('product.show',$cart->product->slug)}}">
                                                    <img src="{{json_decode($cart->product->image)[0]}}" alt="{{$cart->product->name}} image">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="{{route('product.show',$cart->product->slug)}}">{{$cart->product->name}}</a>
                                                <br><small>{{json_decode($cart->detail)->size}} - {{json_decode($cart->detail)->variant}}</small>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">
                                        <div class="d-flex flex-md-column justify-content-center align-items-center">
                                            <div class="new-price">{{Helper::rupiah(($cart->product->discount !== 0 && $cart->product->discount !== null) ? $cart->product->price - $cart->product->price*$cart->product->discount/100 : $cart->product->price)}}</div>
                                            @if ($cart->product->discount !== 0 && $cart->product->discount !== null)
                                                <div class="old-price">{{Helper::rupiah($cart->product->price)}}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity d-flex align-items-center">
                                            <div wire:click="delQty({{$cart->id}})" class="btn-light text-center" style="width: 2em;height:2em;cursor:pointer;">-</div>
                                            <div class="text-decoration-underline p-4">{{$cart->qty}}</div>
                                            <div wire:click="addQty({{$cart->id}})" class="btn-primary text-center" style="width: 2em;height:2em;cursor:pointer;">+</div>
                                        </div><!-- End .cart-product-quantity -->
                                    </td>
                                    <td class="total-col">{{Helper::rupiah(($cart->product->price - $cart->product->price*$cart->product->discount/100)*$cart->qty)}}</td>
                                    <td class="remove-col"><button class="btn-remove" wire:click="delCart({{$cart->id}})"><i class="icon-close"></i></button></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Yaahhh.. keranjangny kosong nih. ayo <a href="{{route('product')}}">berbelanja sekarang juga.</a></td>
                                </tr>
                                @endforelse
                                
                            </tbody>
                        </table><!-- End .table table-wishlist -->

                        <div class="cart-bottom w-100">
                            <div class="cart-discount w-100">
                                <form wire:submit.prevent="coupon">
                                    <div class="input-group">
                                        <input wire:model="coupon" type="text" class="form-control" required placeholder="coupon code">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right">apply</i></button>
                                        </div><!-- .End .input-group-append -->
                                    </div><!-- End .input-group -->
                                </form>
                                @if ($cpnData)
                                    <small class="text-dark">Berhasil mendapatkan coupon potongan {{$cpnData->discount.'%'}} (max. {{Helper::rupiah($cpnData->max)}})</small>
                                @endif
                            </div><!-- End .cart-discount -->
                        </div><!-- End .cart-bottom -->
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>{{Helper::rupiah($total)}}</td>
                                    </tr><!-- End .summary-subtotal -->
                                    @if ($cpnData)
                                    <tr class="summary-subtotal">
                                        <td>Coupon:</td>
                                        <td>-{{Helper::rupiah($cpn)}}</td>
                                    </tr><!-- End .summary-subtotal -->
                                    @endif
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>{{Helper::rupiah($calc)}}</td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <a href="{{route('checkout')}}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                        </div><!-- End .summary -->

                        <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->

</div>
