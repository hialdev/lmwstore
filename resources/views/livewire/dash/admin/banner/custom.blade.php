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
                    <li class="breadcrumb-item active" aria-current="page">Banner Custom</li>
                </ol>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="p-3 rounded bg-white d-inline-flex align-items-center justify-content-center">
                    <span class="iconify" data-icon="ooui:image-gallery"></span>
                </div>
                <h3 class="m-0">Banner Custom</h3>
            </div>
        </div>
        <div class="mt-3 ms-auto">
            @if (isset($banner))
            <button wire:click="edit({{$banner->id}})" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editModal">Edit Banner</a>
            @endif
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Tambah Banner</a>
        </div>
    </div>
    
    <!-- Add --- Vertically Centered modal Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <form wire:submit.prevent="add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Banner</h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="inputSubtitle">Subtitle Banner</label>
                            <input wire:model="subtitle" type="text" class="form-control" id="inputSubtitle">
                            @error('subtitle') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputTitle">Title Banner</label>
                            <input wire:model="title" type="text" class="form-control" id="inputTitle">
                            @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            @if ($image) <div><img src="{{$image->temporaryUrl()}}" alt="Image Preview" style="max-height:3em;"></div> @else <div></div> @endif
                            <label for="helpInputTop">Background Image</label>
                            <input wire:model="image" type="file" class="form-control" id="helpInputTop" value="{{$image}}">
                            <div wire:loading>Uploading...</div>
                            @error('image') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputdesc">Deskripsi</label>
                            <textarea wire:model="desc" rows="5" class="form-control" id="inputdesc"></textarea>
                            @error('desc') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputBtnText">Button Text</label>
                            <input wire:model="btn_text" type="text" class="form-control" id="inputBtnText">
                            @error('btn_text') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputURL">URL</label>
                            <input wire:model="url" type="text" class="form-control" id="inputURL">
                            @error('url') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <span>Close</span>
                        </button>
                        <button wire:click="add" data-bs-dismiss="modal" type="submit" class="btn btn-primary ml-1">
                            Tambah Banner
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
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Banner</h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="inputSubtitle">Subtitle Banner</label>
                            <input wire:model="subtitle" type="text" class="form-control" id="inputSubtitle">
                            @error('subtitle') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputTitle">Title Banner</label>
                            <input wire:model="title" type="text" class="form-control" id="inputTitle">
                            @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            @if (isset($image))
                            <div><img src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-height:3em;"></div>
                            @elseif ( isset($imgedit))
                            <div><img src="{{ asset('storage'.$imgedit) }}" alt="Image Preview" style="max-height:3em;"></div>
                            @endif
                            <label for="helpInputTop">Logo Banner</label>
                            <input wire:model="image" type="file" class="form-control" id="helpInputTop" value="{{$image}}">
                            <div wire:loading>Uploading...</div>
                            @error('image') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputdesc">Deskripsi</label>
                            <textarea wire:model="desc" rows="5" class="form-control" id="inputdesc">{{$desc}}</textarea>
                            @error('desc') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputBtnText">Button Text</label>
                            <input wire:model="btn_text" type="text" class="form-control" id="inputBtnText" value="{{$btn_text}}">
                            @error('btn_text') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputURL">URL</label>
                            <input wire:model="url" type="text" class="form-control" id="inputURL" value="{{$url}}">
                            @error('url') <span class="text-danger error">{{ $message }}</span>@enderror
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

    <div class="p-3 bg-white rounded">
        @if (isset($banner))
        <div class="card bg-dark text-white rounded-0">
            <img src="{{asset('storage'.$banner->image)}}" class="card-img rounded-0" alt="..." style="max-height: 23em;object-fit:cover">
            <div class="card-img-overlay rounded-0 p-4 w-100" style="max-width: 40em">
                <small>{{$banner->subtitle}}</small>
                <h1 class="text-white">{{$banner->title}}</h1>
                <hr>
                <p class="card-text">{{$banner->desc}}</p>
                <a href="{{url($banner->url)}}" class="btn btn-primary">{{$banner->btn_text}}</a>
            </div>
        </div>
        @else
        <div>Belum ada banner custom, dibawah ini adalah dummy data. Silahkan tambah banner</div>
        <div class="card bg-dark text-white rounded-0">
            <img src="/assets/images/products/product2.png" class="card-img rounded-0" alt="..." style="max-height: 23em;object-fit:cover">
            <div class="card-img-overlay rounded-0 p-4 w-100" style="max-width: 40em">
                <small>CUSTOMABLE</small>
                <h1 class="text-white">Pilih Model, Bahan, Motif Sendiri Exclusive.</h1>
                <hr>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum cumque reprehenderit ad. Eum tempore repudiandae animi cumque nisi temporibus ullam eos neque provident aut molestiae quo, consequatur sunt, odio vitae?</p>
                <a href="" class="btn btn-primary">Pesan Custom</a>
            </div>
        </div>
        @endif
    </div>

</div>
