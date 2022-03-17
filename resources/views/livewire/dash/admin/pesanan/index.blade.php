<div>

    @push('style')
    <style>
    .crop-text-4 {
        -webkit-line-clamp: 4;
        overflow : hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }
    </style>
    @endpush
    @if (session()->has('failed'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('failed') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
        <div>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dash.index')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pesanan</li>
                </ol>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="p-3 rounded bg-white d-inline-flex align-items-center justify-content-center">
                    <span class="iconify" data-icon="icon-park-outline:transaction-order"></span>
                </div>
                <h3 class="m-0">Pesanan</h3>
            </div>
        </div>
        <div class="mt-3 ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm" {{count($selected) > 0 ? '' : 'disabled'}}>{{$selectAll === false ? 'Confirm Selected' : 'Bulk Confirm'}}</button>
        </div>
    </div>

    <!-- Table with no outer spacing -->
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
        <div class="w-100 mb-1">
            <input wire:model="q" type="search" class="form-control" placeholder="Cari Invoice / Kode Pesanan...">
        </div>
        <div class="d-flex justify-content-between gap-2 mb-3">
            <div wire:ignore.self style="width: 7.5em"> 
                <select wire:model="filter" class="form-select" id="basicSelect">
                    <option value="0" selected>-- Filter --</option>
                    <option value="1">Terbaru</option>
                    <option value="2">Terdahulu</option>
                    <option value="3">Success</option>
                    <option value="4">Pending</option>
                </select>
            </div>
            <div style="width: 5em"> 
                <select wire:model="limit" class="form-select" id="basicSelect">
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
            {!! $pesanan->links('pagination::bootstrap-4') !!}
        </div>
    </div>

    <div class="table-responsive bg-white" wire:ignore.self>
        <table class="table mb-0 table-md">
            <thead>
                <tr>
                    <th><input type="checkbox" wire:model="selectAll"></th>
                    <th>INV</th>
                    <th>User</th>
                    <th>Penerima</th>
                    <th>Coupon</th>
                    <th>Kode Uniq</th>
                    <th>Tanggal Pesan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanan as $pesanan)
                <tr>
                    <td class="fw-bold"><input type="checkbox" wire:model="selected" value="{{$pesanan->id}}"></td>
                    <td>{{$pesanan->kode_pesanan}} - <div wire:click="detail({{$pesanan->id}})" class="text-decoration-underline badge bg-primary" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#detail">Detail</div></td>
                    <td>{{$pesanan->user->name}}</td>
                    <td>{{$pesanan->alamat->nama_penerima.' | '.$pesanan->alamat->no_penerima.' - '.$pesanan->alamat->tanda.' '.$pesanan->alamat->address.', '.$pesanan->alamat->kota.', '.$pesanan->alamat->provinsi.'. '.$pesanan->alamat->zip}}</td>
                    <td>{{$pesanan->coupon}}</td>
                    <td>{{$pesanan->kode_uniq}}</td>
                    <td>{{$pesanan->created_at->isoFormat('dddd, D MMM Y H:m:s')}}</td>
                    <td>{{Helper::rupiah($pesanan->sum_price)}}</td>
                    <td>
                        @if ($pesanan->status === 1) <span class="badge bg-success">Success</span> @else <span class="badge bg-warning text-dark">Pending</span> @endif
                    </td>
                    <td>
                        <!-- Button trigger for primary themes modal -->
                        @if ($pesanan->status === 1)
                        <button wire:click="unconfirm({{$pesanan->id}})" type="button" class="mb-1 btn btn-light">
                            Batalkan
                        </button>
                        @else
                        <button wire:click="confirmSingle({{$pesanan->id}})" data-bs-toggle="modal" data-bs-target="#confirmSingle" type="button" class="mb-1 btn btn-primary">
                            Konfirmasi
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="17" class="text-center">Tidak ada pesanan berstatus sukses. Silahkan <span class="text-primary">konfirmasi pesanan pending</span>.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if (isset($slct_pesanan))
            <!--primary theme Modal -->
            <div wire:ignore.self class="modal fade text-left" id="detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between bg-primary text-white">
                            <h5 class="modal-title text-white">INV : {{$slct_pesanan->kode_pesanan}}</h5>
                            <p class="m-0">{{$slct_pesanan->created_at->isoFormat('dddd, D MMM Y H:m:s')}}</p>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p>Penerima : <strong>{{$slct_pesanan->alamat->nama_penerima}} - {{$slct_pesanan->alamat->no_penerima}}</strong></p>
                                    <p class="m-0">Alamat : <strong>{{$slct_pesanan->alamat->tanda}}</strong></p>
                                    <p>{{$slct_pesanan->alamat->address.', '.$slct_pesanan->alamat->kota.', '.$slct_pesanan->alamat->provinsi.'. '.$slct_pesanan->alamat->zip}}</p>
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
                                <p class="m-0">{{$slct_pesanan->coupon.' -('.$coupon->discount.'% max.'.Helper::rupiah($coupon->max).')'}}</p>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <p class="fw-bold m-0">Kode Unik</p>
                                <p class="m-0">{{Helper::rupiah($slct_pesanan->kode_uniq)}}</p>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <p class="fw-bold m-0">Total</p>
                                <p class="m-0">{{Helper::rupiah($slct_pesanan->sum_price)}}</p>
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

        <!--Notice Selected Modal -->
        <div wire:ignore.self class="modal fade text-left" id="confirm" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel120">Konfirmasi
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Pastikan pesanan sudah sesuai dan telah terbayar sebelum mengonfirmasi. Apakah anda yakin ingin mengonfirmasi pesanan tersebut?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <span>Batal</span>
                        </button>
                        <button wire:click="confirmSelected" type="button" class="btn btn-primary ml-1"
                            data-bs-dismiss="modal">
                            <i class="bx bx-check"></i>
                            <span>Konfirmasi Pesanan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!--Notice Selected Modal -->
        <div wire:ignore.self class="modal fade text-left" id="confirmSingle" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel120">Konfirmasi
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Pastikan pesanan sudah sesuai dan telah terbayar sebelum mengonfirmasi. Apakah anda yakin ingin mengonfirmasi pesanan tersebut?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <span>Batal</span>
                        </button>
                        <button wire:click="confirm" type="button" class="btn btn-primary ml-1"
                            data-bs-dismiss="modal">
                            <i class="bx bx-check"></i>
                            <span>Konfirmasi Pesanan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
