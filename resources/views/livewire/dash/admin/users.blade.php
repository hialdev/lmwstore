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
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="p-3 rounded bg-white d-inline-flex align-items-center justify-content-center">
                    <span class="iconify" data-icon="fa:group"></span>
                </div>
                <h3 class="m-0">Users</h3>
            </div>
        </div>
        <div class="mt-3 ms-auto">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#danger" {{count($selected) > 0 ? '' : 'disabled'}}>{{$selectAll === false ? 'Delete Selected' : 'Bulk Delete'}}</button>
        </div>
    </div>
    <!-- Table with no outer spacing -->
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
        <div class="w-100 mb-3">
            <input wire:model="q" type="search" class="form-control" placeholder="Cari User..">
        </div>
        <div class="d-flex justify-content-between gap-2">
            <div style="width: 5em"> 
                <select wire:model="limit" class="form-select" id="basicSelect">
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
            {!! $user->links('pagination::bootstrap-4') !!}
        </div>
    </div>
    <div class="table-responsive bg-white" wire:ignore.self>
        <table class="table mb-0 table-md">
            <thead>
                <tr>
                    <th><input type="checkbox" wire:model="selectAll"></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user as $u)
                <tr>
                    <td class="fw-bold"><input type="checkbox" wire:model="selected" value="{{$u->id}}"></td>
                    <td class="d-flex align-items-center">
                        <img src="{{isset($u->image)?asset('storage/'.$u->image):'https://ui-avatars.com/api/?name='.$u->name.'&background=0D8ABC&color=fff'}}" alt="{{$u->name}}" class="d-inline-block me-2" style="width: 2.6em;height:2.6em;object-fit:cover;border-radius:5px">
                        <div>
                            {{$u->name}} <br> <i>{{$u->username}}</i>
                        </div>
                    </td>
                    <td>{{$u->email}}</td>
                    <td>{{$u->phone}}</td>
                    <td>
                        <button wire:click="delSingle({{$u->id}})" data-bs-toggle="modal" data-bs-target="#delSingle" class="btn btn-sm btn-danger mb-1">Del</button>
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

        <!--Delete Single Modal -->
        <div wire:ignore.self class="modal fade text-left" id="delSingle" tabindex="-1" role="dialog"
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
                    <button wire:click="del({{$selectId}})" type="button" class="btn btn-danger ml-1"
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Hapus Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
