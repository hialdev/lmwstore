<div>

    <div class="container py-md-3">
        <div class="mx-auto w-100 p-4 border" style="max-width: 70em">
            <div class="d-flex flex-column flex-md-row justify-content-between">
                <div>
                    <h3>INV : {{$pesanan->kode_pesanan}}</h3>
                    <p>{{$pesanan->created_at}}</p>
                </div>
                <div>
                    <p>status</p>
                    @if ($pesanan->status === 0)
                    <h4 class="text-danger">Pending</h4>
                    @else
                    <h4 class="text-success">Sukses Terkonfirmasi</h4>
                    @endif
                </div>
            </div>
            <div class="text-center pt-3">
                <p>Bayar pesanan dengan Harga : <br>(harus tepat dan sesuai)</p>
                <h1>{{Helper::rupiah($pesanan->sum_price)}}</h1>
                <p>Bayar sebelum :</p>
                <h5>{{$pesanan->created_at->addDays(1)->isoFormat('dddd, D MMM Y')}}</h5>
                <button wire:click="confirm" class="btn btn-primary" {{$pesanan->status === 0 ? '' : 'disabled'}}>Konfirmasi Pembayaran</button>
                <hr>
                <p>Rekening Pembayaran yang tersedia:</p>
                <div class="w-100 mx-auto my-4" style="max-width: 35em">
                    <table class="table">
                        <tr>
                            <td>
                                <img src="/assets/images/bank/bca-logo.jpg" alt="" class="d-block" style="max-height: 4em;">
                            </td>
                            <td class="text-left">
                                <h6 class="m-0">BCA</h6>
                                <h4 class="m-0">8172398642</h4>
                                <p>PT. Langgeng Makmur Wijaya</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="/assets/images/bank/bni-logo.png" alt="" class="d-block" style="max-height: 4em;">
                            </td>
                            <td class="text-left">
                                <h6 class="m-0">BNI</h6>
                                <h4 class="m-0">8172398642</h4>
                                <p>PT. Langgeng Makmur Wijaya</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="/assets/images/bank/bsi-logo.png" alt="" class="d-block" style="max-height: 4em;">
                            </td>
                            <td class="text-left">
                                <h6 class="m-0">BSI</h6>
                                <h4 class="m-0">8172398642</h4>
                                <p>PT. Langgeng Makmur Wijaya</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-outline-primary w-100 my-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Lihat Detail Pesanan / Invoice
    </button>
    <div class="container pt-md-3 collapse" id="collapseExample">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div>
                <h3>INV : {{$pesanan->kode_pesanan}}</h3>
                <p>Pemesan : {{$pesanan->user->name}}</p>
                <h6>Penerima</h6>
                <p class="h4">{{$pesanan->alamat->nama_penerima}} - {{$pesanan->alamat->no_penerima}}</p>
                <p>Alamat : {{$pesanan->alamat->address.', '.$pesanan->alamat->kota.', '.$pesanan->alamat->provinsi.'. '.$pesanan->alamat->zip}}</p>
            </div>
            <div class="mt-2">
                <p>{{$pesanan->created_at}}</p>
                <p class="h4 {{$pesanan->status === 0 ? 'text-danger' : 'text-success'}}">{{$pesanan->status === 0 ? 'Belum dibayar' : 'Sudah dibayar'}}</p>
            </div>
        </div>
        <hr>
        <table class="table table-hover p-3">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Product</th>
                <th scope="col">Qty</th>
                <th scope="col">Price</th>
              </tr>
            </thead>
            <tbody>
                @forelse ($pdtl as $pd)
                <tr>
                    <th scope="row">{{$loop->index}}</th>
                    <td>
                        <div class="d-flex p-3" style="gap:1em;">
                            <img src="{{json_decode($pd->product->image)[0]}}" alt="{{$pd->product->name}}" class="d-block" style="width: 4em;height:4em;">
                            <div>
                                <p>{{$pd->product->name}}</p>
                                <p>{{json_decode($pd->detail)->size.' - '.json_decode($pd->detail)->variant}}</p>
                            </div>
                        </div>
                    </td>
                    <td>{{$pd->qty . ' x ' . Helper::rupiah($pd->product->price - $pd->product->price*$pd->product->discount/100)}}</td>
                    <td>{{Helper::rupiah(($pd->product->price - $pd->product->price*$pd->product->discount/100)*$pd->qty)}}</td>
                </tr>
                @empty
                    
                @endforelse
                <tr>
                    <td class=""><h6>Subtotal Products</h6></td>
                    <td colspan="2"></td>
                    <td >{{Helper::rupiah($total)}}</td>
                </tr>
                <tr>
                    <td class=""><h6>Subtotal Coupon ({{$pesanan->coupon}})</h6></td>
                    <td colspan="2"></td>
                    <td >- {{Helper::rupiah($coupon)}}</td>
                </tr>
                <tr>
                    <td class=""><h6>Shipping / Pengiriman</h6></td>
                    <td colspan="2"></td>
                    <td >{{Helper::rupiah(0)}}</td>
                </tr>
                <tr>
                    <td class=""><h6>Kode Unik</h6></td>
                    <td colspan="2"></td>
                    <td >{{Helper::rupiah($pesanan->kode_uniq)}}</td>
                </tr>
                <tr>
                    <td class=""><h5>Total</h5></td>
                    <td colspan="2"></td>
                    <td >{{Helper::rupiah($pesanan->sum_price)}}</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
