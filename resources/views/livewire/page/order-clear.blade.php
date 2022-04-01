<div>
    @livewire('dash.user.banner')
    
    <!-- Basic Tables start -->
    <section class="section">
        <div class="pb-3">
            Status : <span class="badge bg-success">Success</span>
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada pesanan berstatus sukses. Silahkan bayar <a href="{{route('order.pending')}}">pesanan pending</a> anda, dan konfirmasikan kepada admin jika anda sudah membayar pesanan.</td>
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
                                        </div>
                                    </div>
                                    @foreach ($details as $detail)
                                    <div class="row align-items-center py-2 border-bottom">
                                        <div class="col-2">
                                            <img src="{{asset('storage'.json_decode($detail->product->image)[0])}}" alt="{{$detail->product->name}}" class="d-block" style="width:4em;height:4em;object-fit:cover">
                                        </div>
                                        <div class="col-6">
                                            <strong>{{$detail->product->name}}</strong>
                                            <br>{{json_decode($detail->detail)->size.' - '.json_decode($detail->detail)->variant}}
                                        </div>
                                        <div class="col-4">
                                            {{$detail->qty.' x '.Helper::rupiah($detail->product->price-$detail->product->price*$detail->product->discount/100)}}
                                        </div>
                                    </div>
                                    @endforeach
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
