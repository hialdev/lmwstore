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
                    <li class="breadcrumb-item active" aria-current="page">SEO Meta Tags</li>
                </ol>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="p-3 rounded bg-white d-inline-flex align-items-center justify-content-center">
                    <span class="iconify" data-icon="bi:file-earmark-code-fill"></span>
                </div>
                <h3 class="m-0">SEO Meta Tags</h3>
            </div>
        </div>
        <div class="mt-3 ms-auto">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#danger" {{count($selected) > 0 ? '' : 'disabled'}}>{{$selectAll === false ? 'Delete Selected' : 'Bulk Delete'}}</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Tambah SEO</a>
        </div>
    </div>

    <!-- Table with no outer spacing -->
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
        <div class="w-100 mb-3">
            <input wire:model="q" type="search" class="form-control" placeholder="Cari SEO...">
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
            {!! $seo->links('pagination::bootstrap-4') !!}
        </div>
    </div>
    
    <!-- Add --- Vertically Centered modal Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <form wire:submit.prevent="add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah SEO</h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Page</label>
                            <fieldset class="form-group mb-3">
                                <select wire:model="id_page" class="form-select" id="basicSelect">
                                    <option>-- Pilih Page --</option>
                                    @foreach ($pages as $page)
                                    <option value="{{$page->id}}">{{$page->name}}</option>
                                    @endforeach
                                </select>
                                @error('id_page') <span class="text-danger error">{{ $message }}</span>@enderror
                            </fieldset>
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputtitle">Title</label>
                            <input wire:model="title" type="text" class="form-control" id="inputtitle">
                            @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputtype">Type</label>
                            <input wire:model="type" type="text" class="form-control" id="inputtype">
                            @error('type') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            @if ($image) <div><img src="{{$image->temporaryUrl()}}" alt="Image Preview" style="max-height:3em;"></div> @else <div></div> @endif
                            <label for="helpInputTop">Meta Image</label>
                            <input wire:model="image" type="file" class="form-control" id="helpInputTop">
                            <div wire:loading wire:target="image">Uploading...</div>
                            @error('image') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputdesc">Deskripsi</label>
                            <textarea wire:model="desc" rows="5" class="form-control" id="inputdesc"></textarea>
                            @error('desc') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <span>Close</span>
                        </button>
                        <button wire:click="add" data-bs-dismiss="modal" type="submit" class="btn btn-primary ml-1">
                            Tambah SEO
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit --- Vertically Centered modal Modal -->
    @if ($editModal === true)
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <form wire:submit.prevent="update({{$selectId}})">    
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit SEO</h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Page</label>
                            <fieldset class="form-group mb-3">
                                <select wire:model="id_page" class="form-select" id="basicSelect">
                                    <option>-- Pilih Page --</option>
                                    @foreach ($pages as $page)
                                    <option value="{{$page->id}}">{{$page->name}}</option>
                                    @endforeach
                                </select>
                                @error('id_page') <span class="text-danger error">{{ $message }}</span>@enderror
                            </fieldset>
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputtitle">Title</label>
                            <input wire:model="title" type="text" class="form-control" id="inputtitle" value="{{$title}}">
                            @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputtype">Type</label>
                            <input wire:model="type" type="text" class="form-control" id="inputtype" value="{{$type}}">
                            @error('type') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            @if ($image) <div><img src="{{$image->temporaryUrl()}}" alt="Image Preview" style="max-height:3em;"></div> @else <div></div> @endif
                            <label for="helpInputTop">Meta Image</label>
                            <input wire:model="image" type="file" class="form-control" id="helpInputTop" value="{{$image}}">
                            <div wire:loading wire:target="image">Uploading...</div>
                            @error('image') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputdesc">Deskripsi</label>
                            <textarea wire:model="desc" rows="5" class="form-control" id="inputdesc">{{$desc}}</textarea>
                            @error('desc') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="blank" type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <span>Close</span>
                        </button>
                        <button wire:click="update({{$selectId}})" type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

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
                    <th>Page</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Desc</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($seo as $s)
                <tr>
                    <td class="fw-bold"><input type="checkbox" wire:model="selected" value="{{$s->id}}"></td>
                    <td><span class="badge bg-light-primary">{{$s->page->name}}</span></td>
                    <td><img src="{{asset('storage'.$s->image)}}" alt="{{$s->name}}" style="max-height:3em;"></td>
                    <td>{{$s->title}}</td>
                    <td><div class="crop-4">{{$s->desc}}</div></td>
                    <td>{{$s->type}}</td>
                    <td>
                        <button wire:click="edit({{$s->id}})" class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                        <button wire:click="delSingle({{$s->id}})" data-bs-toggle="modal" data-bs-target="#delSingle" class="btn btn-sm btn-danger mb-1">Del</button>
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

</div>
