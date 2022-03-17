<div>
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <a href="{{'/'}}" class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple text-white">
                                        <span class="iconify" data-icon="icon-park-outline:transaction-order" style="width:2em;height:2em"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Transaction</h6>
                                    <h6 class="font-extrabold mb-0">726</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <a href="{{'/'}}" class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue text-white">
                                        <span class="iconify" data-icon="fa6-solid:user" style="width:2em;height:2em"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Costumers</h6>
                                    <h6 class="font-extrabold mb-0">183.000</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <a href="{{route('dash.product')}}" class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green text-white">
                                        <span class="iconify" data-icon="fa-solid:tshirt" style="width:2em;height:2em"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Products</h6>
                                    <h6 class="font-extrabold mb-0">80.000</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <a href="{{'/'}}" class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red text-white">
                                        <span class="iconify" data-icon="ant-design:tag-filled" style=" width:2em;height:2em"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Categories</h6>
                                    <h6 class="font-extrabold mb-0">112</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Latest Transaction</h4>
                            <a href="" class="btn btn-outline-primary">Lihat Semua</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>INV</th>
                                            <th>Product</th>
                                            <th>Total (Kd Uniq)</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesanans as $pesanan)
                                        <tr>
                                            <td>{{$pesanan->kode_pesanan}}</td>
                                            <td>
                                                @foreach (\App\Models\Pesanan::detail($pesanan->id) as $p)
                                                    <span class="badge bg-light-primary">
                                                        {{$p->qty.' x '.$p->product->name}}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>{{Helper::rupiah($pesanan->sum_price).' ('.$pesanan->kode_uniq.')'}}</td>
                                            <td>{{$pesanan->created_at->format('d-m-y H:i:s')}}</td>
                                            <td>
                                                @if ($pesanan->status === 0)
                                                    <div class="p-1 px-2 rounded bg-warning text-dark">Pending</div>
                                                @else
                                                    <div class="p-1 px-2 rounded bg-success text-white">Pending</div>
                                                @endif    
                                            </td>
                                            <td><button wire:model="confirm" class="btn btn-primary">Konfirmasi</button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <a href="" class="card">
                        <div class="card-header">
                            <h4>Recent Mails</h4>
                        </div>
                        <div class="card-content pb-4">
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="stats-icon bg-primary text-white">
                                    <span class="iconify" data-icon="uiw:mail" style="width:2em;height:2em"></span>
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1">Hank Schrader</h5>
                                    <h6 class="text-muted mb-0">@johnducky</h6>
                                </div>
                            </div>
                            <div class="px-4">
                                <button class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>Lihat Semua</button>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
