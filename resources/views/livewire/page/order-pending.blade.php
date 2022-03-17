<div>
    @livewire('dash.user.banner')

    <!-- Basic Tables start -->
    <div class="alert bg-warning bg-opacity-25 orange" role="alert">
        Perhatikan waktu tenggang pembayaran. <br>
        Jika sudah membayar harap melakukan konfirmasi, dan tunggu admin mengonfirmasi pesanan.
    </div>
    <section class="section">
        
        <div class="pb-3">
            Status : <span class="badge bg-warning text-dark">Pending</span>
        </div>
        <div class="card">
            <div class="card-body overflow-auto">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>INV</th>
                            <th>Coupon</th>
                            <th>Tanggal Pesan</th>
                            <th>Total Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanan as $pesanan)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$pesanan->kode_pesanan}}</td>
                            <td>{{$pesanan->coupon}}</td>
                            <td>{{$pesanan->created_at->isoFormat('dddd, D MMM Y H:m:s')}}</td>
                            <td>{{Helper::rupiah($pesanan->sum_price)}}</td>
                            <td>
                                <!-- Button trigger for primary themes modal -->
                                <button wire:click="detailPesanan({{$pesanan->id}})" type="button" class="mb-1 btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#primary">
                                    Detail
                                </button>
                                <button wire:click="detailPesanan({{$pesanan->id}})" type="button" class="mb-1 btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#bayar">
                                    Bayar
                                </button>
                                <a href="" class="btn btn-success">Konfirmasi</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada pesanan pending. Mari <a href="{{route('product')}}">berbelanja lagi!</a></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if (isset($selected))
                    <!--primary theme Modal -->
                    <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between">
                                    <h5 class="modal-title text-dark">INV : {{$selected->kode_pesanan}}</h5>
                                    <p class="m-0">{{$selected->created_at->isoFormat('dddd, D MMM Y H:m:s')}}</p>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p>Penerima : <strong>{{$selected->alamat->nama_penerima}} - {{$selected->alamat->no_penerima}}</strong></p>
                                            <p class="m-0">Alamat : <strong>{{$selected->alamat->tanda}}</strong></p>
                                            <p>{{$selected->alamat->address.', '.$selected->alamat->kota.', '.$selected->alamat->provinsi.'. '.$selected->alamat->zip}}</p>
                                            <p>Catatan : {{$selected->note}}</p>
                                        </div>
                                    </div>
                                    @forelse ($details as $detail)
                                    <div class="row align-items-center py-2 border-bottom">
                                        <div class="col-2">
                                            <img src="{{json_decode($detail->product->image)[0]}}" alt="{{$detail->product->name}}" class="d-block" style="width:4em;height:4em;object-fit:cover">
                                        </div>
                                        <div class="col-6">
                                            <strong>{{$detail->product->name}}</strong>
                                            <br>{{json_decode($detail->detail)->size.' - '.json_decode($detail->detail)->variant}}
                                        </div>
                                        <div class="col-4">
                                            {{$detail->qty.' x '.Helper::rupiah($detail->product->price-$detail->product->price*$detail->product->discount/100)}}
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="6">Tidak ada pesanan berstatus sukses. Silahkan bayar pesanan pending anda, dan konfirmasikan kepada admin jika anda sudah membayar pesanan.</td>
                                    </tr>
                                    @endforelse
                                    @if ($coupon)
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <p class="fw-bold m-0">Coupon</p>
                                        <p class="m-0">{{$selected->coupon.' -('.$coupon->discount.'% max.'.Helper::rupiah($coupon->max).')'}}</p>
                                    </div>
                                    @endif
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <p class="fw-bold m-0">Kode Unik</p>
                                        <p class="m-0">{{Helper::rupiah($selected->kode_uniq)}}</p>
                                    </div>
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <p class="fw-bold m-0">Total</p>
                                        <p class="m-0">{{Helper::rupiah($selected->sum_price)}}</p>
                                    </div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-danger w-100 mt-3">Batalkan Pesanan</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin membatalkan pesanan?</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Klik batal pesan untuk membatalkan pesanan, klik lanjut pesan untuk melanjutkan pemesanan dan tidak jadi cancel order. <br>
                                                    Jika anda ada masalah dengan pemesanan bisa menghubungi admin LMW.
                                                </div>
                                                <div class="modal-footer">
                                                    <button wire:click="delPesanan({{$selected->id}})" type="button" class="btn btn-danger">Ya, Batalkan</button>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tidak, Lanjutkan Pesanan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <span>Close</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--primary theme Modal -->
                    <div class="modal fade text-left" id="bayar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel160">INV : {{$selected->kode_pesanan}}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center pt-3">
                                        <p>Bayar pesanan dengan Harga : <br>(harus tepat dan sesuai)</p>
                                        <h1>{{Helper::rupiah($selected->sum_price)}}</h1>
                                        <p>Bayar sebelum :</p>
                                        <h5>{{$selected->created_at->addDays(1)->isoFormat('dddd, D MMM Y H:m:s')}}</h5>
                                        <button wire:click="confirm" class="btn btn-primary">Konfirmasi Pembayaran</button>
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
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <span>Close</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </section>
    <!-- Basic Tables end -->

</div>
