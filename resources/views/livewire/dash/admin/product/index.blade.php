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
                    <li class="breadcrumb-item active" aria-current="page">List Product</li>
                </ol>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="p-3 rounded bg-white d-inline-flex align-items-center justify-content-center">
                    <span class="iconify" data-icon="fa-solid:tshirt"></span>
                </div>
                <h3 class="m-0">List Products</h3>
            </div>
        </div>
        <div class="mt-3 ms-auto">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#danger" {{count($selectedProducts) > 0 ? '' : 'disabled'}}>{{$selectAll === false ? 'Delete Selected' : 'Bulk Delete'}}</button>
            <a href="{{route('dash.product.add')}}" class="btn btn-primary">Tambah Product</a>
        </div>
    </div>

    <!-- Table with no outer spacing -->
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
        <div class="w-100 mb-3">
            <input wire:model="q" type="search" class="form-control" placeholder="Cari Product..">
        </div>
        @if ($q === null)
        <div class="d-flex justify-content-between gap-2">
            <div style="width: 5em"> 
                <select wire:model="limit" class="form-select" id="basicSelect">
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
            {!! $products->links('pagination::bootstrap-4') !!}
        </div>
        @endif
    </div>

    <!--Delete Selected Modal -->
    <div class="modal fade text-left" id="danger" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Peringatan
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Data yang anda akan hapus tidak dapat dikembalikan lagi. Apakah anda yakin ingin menghapus data tersebut?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button wire:click="deleteSelected" type="button" class="btn btn-danger ml-1"
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Hapus Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive bg-white" wire:ignore.self>
        <table class="table mb-0 table-md">
            <thead>
                <tr>
                    <th><input type="checkbox" wire:model="selectAll"></th>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Brief</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Deskripsi</th>
                    <th>Stock</th>
                    <th>Preorder</th>
                    <th>Size</th>
                    <th>Variant</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Update</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td class="fw-bold"><input type="checkbox" wire:model="selectedProducts" value="{{$product->id}}"></td>
                    <td>{{$product->name}}</td>
                    <td>
                        <div class="d-flex">
                            @foreach (json_decode($product->image) as $img)
                                <img src="{{asset('storage'.$img)}}" alt="{{$product->name}} image {{$loop->index}}" style="width: 3em;height:3em; object-fit:cover">
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="crop-text-4" style="width: 10em">
                            {{$product->brief}}
                        </div>
                    </td>
                    <td>{{Helper::rupiah($product->price)}}</td>
                    <td>{{$product->discount.'%'}}</td>
                    <td>
                        <div class="crop-text-4" style="width: 10em">
                            {{$product->desc}}
                        </div>
                    </td>
                    <td>{{$product->stock}}</td>
                    <td>{{$product->preorder === 0 ? 'Close PO': 'Open PO'}}</td>
                    <td>
                        @foreach (json_decode($product->size) as $size)
                            <span class="badge bg-light-primary">{{$size}}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach (json_decode($product->variant) as $variant)
                            <span class="badge bg-light-primary">{{$variant}}</span>
                        @endforeach
                    </td>
                    <td>
                        <img src="{{$product->brand->image}}" alt="{{$product->brand->name}} logo" style="height: 3em;">
                    </td>
                    <td>
                        @foreach ($product->categories as $ctg)
                            <span class="badge bg-light-primary">{{$ctg->name}}</span>
                        @endforeach
                    </td>
                    <td>{{$product->updated_at->isoFormat('dddd, DD-MM-YYYY, H:m:s')}}</td>
                    <td>
                        <a href="{{route('product.show',$product->slug)}}" target="_blank" class="btn btn-sm btn-secondary mb-1">View</a>
                        <a href="{{route('dash.product.edit',$product->id)}}" class="btn btn-sm btn-primary mb-1">Edit</a>
                        <button wire:click="delProduct({{$product->id}})" class="btn btn-sm btn-danger">Del</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="16">
                        Tidak ada data untuk ditampilkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
