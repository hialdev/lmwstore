<div>
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

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('cart')}}">View Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="checkout">
            <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2>Checkout</h2>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                            <h6>Product ({{$data['count']}})</h6>
                            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": false,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":1
                                    },
                                    "480": {
                                        "items":1
                                    },
                                    "992": {
                                        "items":2
                                    },
                                    "1200": {
                                        "items":3
                                    }
                                }
                            }' wire:ignore.self>
                            @foreach ($data['data'] as $cart)
                                <div class="d-flex border-right pr-4" style="gap:1em">
                                    <img src="{{asset('storage'.json_decode($cart->product->image)[0])}}" alt="{{$cart->product->name}}" style="width:5em;height:5em;display-block">
                                    <div>
                                        <a class="text-dark" href="{{route('product.show',$cart->product->slug)}}">{{$cart->product->name}}</a>
                                        <div><strong>{{$cart->qty}} x {{Helper::rupiah($cart->product->price-$cart->product->price*$cart->product->discount/100)}}</strong> <span style="text-decoration:line-through">{{Helper::rupiah($cart->product->price)}}</span></div>
                                        <div><small>{{json_decode($cart->detail)->size.' - '.json_decode($cart->detail)->variant}}</small></div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <div class="bg-light p-4 mb-2">
                                <h6> Alamat Penerima yang dipilih :</h6>
                                
                                @if (count($alamats)>0)
                                <div class="select-custom">
                                    <select wire:model="select_alamat" id="alamat" class="form-control">
                                        @foreach ($alamats as $alamat)
                                            @if ($alamat->priority === 1)
                                                <option value="{{$alamat->tanda}}" selected><strong>{{$alamat->tanda}} | </strong>{{$alamat->nama_penerima.' - '.$alamat->no_penerima.' - '.$alamat->address}}</option>
                                            @else
                                                <option value="{{$alamat->tanda}}"><strong>{{$alamat->tanda}} | </strong>{{$alamat->nama_penerima.' - '.$alamat->no_penerima.' - '.$alamat->address}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div><!-- End .select-custom -->
                                @else
                                <div>Oooops... Belum ada alamat yang tersimpan, Silahkan tambah alamat penerima.</div>
                                @endif
                                @if (isset($alm))
                                <div class="border border-secondary rounded p-4 mb-2">
                                    <p><strong>{{$alm->tanda}}</strong> - {{$alm->nama_penerima.' | '.$alm->no_penerima}}</p>
                                    <p>{{$alm->address.', '.$alm->kota.', '.$alm->provinsi.'. '.$alm->zip}}</p>
                                </div>
                                @endif
                                
                                <button class="btn btn-primary mt-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    @if (count($alamats)>0)Gunakan Alamat Penerima Lain +@else Tambah Alamat Penerima + @endif
                                </button>
                            </div>
                            <div class="collapse" id="collapseExample" wire:ignore.self>
                                <form wire:submit.prevent="addAlamat" class="border-bottom pb-3">
                                    <h2 class="checkout-title">Tambah Alamat</h2><!-- End .checkout-title -->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Nama Alamat *</label>
                                            <input wire:model="tanda" type="text" class="form-control" placeholder="Tandai alamat ini. Contoh : Rumah ku" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-4">
                                            <label>Nama Penerima *</label>
                                            <input wire:model="nama_penerima" type="text" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-4">
                                            <label>No.HP/WA yang dapat dihubungi *</label>
                                            <input wire:model="no_penerima" type="number" class="form-control no-arrow" required>
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->
                                    
                                    <label>Alamat jalan *</label>
                                    <input wire:model="address" type="text" class="form-control" placeholder="Jl. Jalanan, Rt 00/ Rw 00, no. 00 / blok, Kelurahan, Kecamatan." required>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Town / City *</label>
                                            <input wire:model="kota" type="text" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-4">
                                            <label>State / Provinsi *</label>
                                            <input wire:model="provinsi" type="text" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-4">
                                            <label>Postcode / ZIP *</label>
                                            <input wire:model="zip" type="number" class="form-control no-arrow" required>
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->

                                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                                </form>
                            </div>
                <form wire:submit.prevent="order">
                            <label>Catatan (optional)</label>
                            <textarea wire:model="notes" class="form-control" cols="30" rows="4" placeholder="Catatan, patokan, atau tentang pesanan anda"></textarea>
                            
                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3">
                            <div class="summary">
                                <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                                <table class="table table-summary">
                                    <tbody>
                                        <tr class="summary-subtotal">
                                            <td>Subtotal Product:</td>
                                            <td>{{Helper::rupiah($data["total"])}}</td>
                                        </tr><!-- End .summary-subtotal -->
                                        <tr>
                                            <td>Coupon:</td>
                                            <td>-{{Helper::rupiah($cpn_sale)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Kode Unik:</td>
                                            <td>+{{Helper::rupiah($kd_unik)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping:</td>
                                            <td>Free shipping</td>
                                        </tr>
                                        <tr class="summary-total">
                                            <td>Total:</td>
                                            <td>{{Helper::rupiah($calc)}}</td>
                                        </tr><!-- End .summary-total -->
                                    </tbody>
                                </table><!-- End .table table-summary -->
                                <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                    <span class="btn-text">Place Order</span>
                                    <span class="btn-hover-text">Bayar Sekarang</span>
                                </button>
                            
                            </div><!-- End .summary -->
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </form>
            </div><!-- End .container -->
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->
</div>
