<div>
    
    @if (session()->has('success'))
    <div class="toast-container position-absolute p-3 top-0 end-0">
        <div class="toast">
            <div class="toast-header">
                <strong class="me-auto">Success</strong>
            </div>
            <div class="toast-body">
                {{session('message')}}
            </div>
        </div>
    </div>
    @elseif (session()->has('failed'))
    <div class="toast-container position-absolute p-3 top-0 end-0">
        <div class="toast">
            <div class="toast-header">
                <strong class="me-auto">Failed</strong>
            </div>
            <div class="toast-body">
                {{session('message')}}
            </div>
        </div>
    </div>    
    @endif

    <div class="row">
        <div class="col-8">
            <div class="row mb-4">
                <div class="col-12 mx-auto">
                    <h2>Brand List</h2>
                    <hr>
                    <div class="row">
                        @forelse ($brands as $brand)
                        <div class="col-4">
                            <div wire:click="filterBrand({{$brand->id}})" class="d-block text-decoration-none text-black card border-0 shadow-sm" style="width: 18rem;">
                                <img src="{{$brand->image}}" class="card-img-top" alt="{{$brand->name}}">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{$brand->name}}</h5>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p class="text-center">tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-12 mx-auto">
                    <h2>Product List</h2>
                    <hr>
                    <div class="row">
                        @forelse ($products as $product)
                        @php
                            $image = json_decode($product->image);
                        @endphp
                        <div class="col-4">
                            <div class="card border-0 shadow-sm" style="width: 18rem;">
                                <img src="{{$image[0]}}" class="card-img-top" alt="{{$product->name}}">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{$product->name}}</h5>
                                    <p>{{$product->desc}}</p>
                                    <p class="card-text p-3 bg-light"><strong>{{Helper::rupiah($product->price)}}</strong> - {{$product->stock}} | {{$product->brand->name}}</p>
                                    <button wire:click="addCart({{$product->id}})" class="btn btn-primary w-100">Add to cart</button>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p class="text-center">tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="p-4 bg-white rounded">
                <h2>Keranjang</h2>
                <hr>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($carts as $index=>$cart)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$cart->product->name}}</td>
                                <td>{{$cart->qty}}</td>
                                <td>{{Helper::rupiah($cart->qty*$cart->product->price)}}</td>
                                <td><button wire:click="delCart({{$cart->id}})" class="btn btn-danger">Hapus</button></td>
                            </tr>
                        @empty
                            <tr><td class="text-center" colspan="6">Keranjang kosong</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-white rounded mt-3">
                <input type="text" wire:model="qcoupon" id="" class="form-control" placeholder="Kode Coupon (Jika ada)" style="text-transform:uppercase">

                @if ($coupon !== null)
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>Diskon Coupon : {{$coupon->code}} </div>
                    <strong>-{{$coupon->disc*100}}% (max. {{$coupon->max}})</strong>
                </div>
                @elseif ($coupon === null && $qcoupon !== null)
                    <div class="text-center">Kupon tidak tersedia</div>
                @elseif ($qcoupon === null)
                    <div></div>
                @endif
            </div>

            <div class="p-4 bg-white rounded mt-3">
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>Total Harga</div>
                    <strong>{{Helper::rupiah($total)}}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>Diskon Coupon</div>
                    <strong>-{{Helper::rupiah($coupon?$total_disc:0)}}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>PPN(10%)</div>
                    <strong>+{{Helper::rupiah($ppn)}}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>Total Harga Akhir</div>
                    <strong>{{Helper::rupiah($total_seluruh)}}</strong>
                </div>
            </div>
        </div>
    </div>

</div>
