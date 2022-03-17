<div>

    @push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
{{-- Form Start --}}
    <form wire:submit.prevent="update">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <div>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dash.index')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="p-3 rounded bg-white d-inline-flex align-items-center justify-content-center">
                        <span class="iconify" data-icon="fa-solid:tshirt"></span>
                    </div>
                    <h3 class="m-0">Tambah Products</h3>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2"><span class="iconify" data-icon="ion:save"></span> Simpan</button>
            </div>
        </div>

        <div class="mt-2 p-3 rounded bg-white">
                <div class="row">
                    <div class="d-flex flex-wrap align-items-start mb-2 gap-2">
                        @if ($imageData)
                            @foreach ($imageData as $image)
                            <div>
                                <img src="{{ asset('storage'.$image) }}" style="width:10.8em;height:10.8em;object-fit:cover" class="d-block">
                                <button type="button" wire:click="delImage('{{$image}}')" class=" w-100 p-2 btn-danger">Hapus</button>
                            </div>
                            @endforeach
                        @endif
                        @if ($images)
                            @foreach ($images as $img)
                                <img src="{{ $img->temporaryUrl()}}" style="width:10.8em;height:10.8em;object-fit:cover">    
                            @endforeach
                        @endif
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Image Product (Multiple)</label>
                            <input type="file" class="form-control" wire:model="images" multiple>
                            @error('images') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="inputNama">Nama / Title Product</label>
                    <input wire:model="name" type="text" class="form-control" id="inputNama" placeholder="Nama Product" value="{{$name}}">
                    @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-3">
                    <label for="inputSlug">Slug</label>
                    <input type="text" class="form-control" id="inputSlug" placeholder="Slug" value="{{Str::slug($name)}}" disabled>
                </div>
                <div class="row mb-3">
                    <div class="col-4 col-md-4">
                        <div class="form-group mb-3">
                            <label for="inputPrice">Price</label>
                            <input wire:model="price" type="number" class="form-control no-arrow" id="inputPrice" placeholder="Harga product" value="{{$price}}">
                            @error('price') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4 col-md-4">
                        <div class="form-group mb-3">
                            <label for="inputStock">Stock</label>
                            <input wire:model="stock" type="number" class="form-control no-arrow" id="inputStock" placeholder="Stock" value="{{$stock}}">
                            @error('stock') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4 col-md-4">
                        <div class="form-group mb-3">
                            <label for="inputDiscount">Discount</label>
                            <input wire:model="discount" type="number" class="form-control no-arrow" id="inputDiscount" placeholder="Discount %" value="{{$discount}}">
                            @error('discount') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Brand</label>
                            <fieldset class="form-group mb-3">
                                <select wire:model="brand" class="form-select" id="basicSelect">
                                    <option>-- Pilih Brand --</option>
                                    @foreach ($brands as $brnd)
                                    @if ($brnd->id === $brand)
                                        <option value="{{$brnd->id}}" selected>{{$brnd->name}}</option>
                                    @else
                                        <option value="{{$brnd->id}}">{{$brnd->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('brand') <span class="text-danger error">{{ $message }}</span>@enderror
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Status Preorder</label>
                            <fieldset class="form-group mb-3">
                                <select wire:model="po" class="form-select" id="basicSelect">
                                    <option>-- Pilih Status PO --</option>
                                    <option value="{{0}}" {{$po === 0 ? 'selected':''}}>Tidak, Close PO</option>
                                    <option value="{{1}}" {{$po === 1 ? 'selected':''}}>Ya, Open PO</option>
                                </select>
                                @error('po') <span class="text-danger error">{{ $message }}</span>@enderror
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Label</label>
                            <fieldset class="form-group mb-3">
                                <select wire:model="label" class="form-select" id="basicSelect">
                                    <option>-- Pilih Label --</option>
                                    @foreach ($labels as $labl)
                                        <option value="{{$labl->id}}" {{$label === $labl->id ? 'selected' : ''}}>{{$labl->name}}</option>
                                    @endforeach
                                </select>
                                @error('label') <span class="text-danger error">{{ $message }}</span>@enderror
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Category</label>
                            <fieldset class="form-group mb-3" wire:ignore>
                                <select wire:model="ctg" class="form-select" id="ctg" multiple>
                                    @foreach ($category as $cat)
                                        <option value="{{$cat->id}}" {{in_array($cat->id,$ctg) ? 'selected' : ''}}>{{$cat->name}}</option>
                                    @endforeach
                                </select>
                                @error('ctg') <span class="text-danger error">{{ $message }}</span>@enderror
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <label for="">Kelola Size Product</label>
                                    <div class="d-flex gap-2 w-100">
                                        <div class="mb-2">
                                            <button class="btn text-white btn-primary" wire:click.prevent="addSize({{$iSize}})">+</button>
                                        </div>
                                    </div>
                                </div>
                                @foreach($inputSize as $key => $value)
                                <div>
                                    <div class="d-flex gap-2 w-100">
                                        <div class="form-group mb-3 w-100">
                                            <input value="{{$value}}" type="text" class="form-control" placeholder="Size Lainnya" wire:model="size.{{ $key }}" value="{{$value}}">
                                            @error('size.{{ $value }}') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="">
                                            <button class="btn text-white btn-danger btn" wire:click.prevent="removeSize({{$key}})">-</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-12 col-md-6">
                                <div>
                                    <label for="">Kelola Variant Product</label>
                                    <div class="d-flex gap-2 w-100">
                                        <div class="mb-2">
                                            <button class="btn text-white btn-primary btn" wire:click.prevent="addVariant({{$iVariant}})">+</button>
                                        </div>
                                    </div>
                                </div>
                                @foreach($inputVariant as $key => $value)
                                <div>
                                    <div class="d-flex gap-2 w-100">
                                        <div class="form-group mb-3 w-100">
                                            <input type="text" class="form-control" placeholder="Variant Lainnya" wire:model="variant.{{ $key }}" value="{{$value}}">
                                            @error('variant.{{ $value }}') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="">
                                            <button class="btn text-white btn-danger btn" wire:click.prevent="removeVariant({{$key}})">-</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Singkat</label>
                            <textarea wire:model="brief" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$brief}}</textarea>
                            @error('brief') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div wire:ignore class="form-group mb-3">
                            <label class="col-form-label" for="editor">Deskripsi Lengkap</label>
                            <div>
                                <textarea wire:model="desc" class="form-control required" name="desc" id="editor">{!! $desc !!}</textarea>
                                @error('desc') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 w-100 justify-content-center"><span class="iconify" data-icon="ion:save"></span> Simpan</button>
        </div>
    </form> 
    {{-- End Form --}}

    @push('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('desc', editor.getData());
                })
            })
            .catch(error => {
            console.error(error);
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#ctg').select2({
                multiple: true,
            });
            $('#ctg').on('change',function(){
                @this.ctg = $(this).val();
            });
        });
    
    </script>
    @endpush

</div>
