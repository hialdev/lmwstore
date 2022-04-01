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
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="p-3 rounded bg-white d-inline-flex align-items-center justify-content-center">
                    <span class="iconify" data-icon="ant-design:setting-filled"></span>
                </div>
                <h3 class="m-0">Settings</h3>
            </div>
        </div>
        <form wire:submit.prevent="save">
        <div class="mt-3 ms-auto">
            <button class="btn btn-primary" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Simpan</a>
        </div>
    </div>

    <div>
            <h6>Site Setting</h6>
            <hr>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        @if (isset($logo))
                            @if (is_object($logo))
                            <div><img src="{{ $logo->temporaryUrl() }}" alt="Logo Site Preview" style="max-height:3em;"></div>
                            @else
                            <div><img src="{{ asset('storage'.$logo) }}" alt="Logo Site Preview" style="max-height:3em;"></div>
                            @endif
                        @endif
                        <label for="helpInputTop">Logo Site</label>
                        <input wire:model="logo" type="file" class="form-control" id="helpInputTop">
                        <div wire:loading wire:target="logo">Uploading...</div>
                        @error('logo') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        @if (isset($favicon)) <div><img src="{{!is_object($favicon) ? asset('storage'.$favicon) : $favicon->temporaryUrl()}}" alt="Favicon Preview" style="max-height:3em;"></div> @else <div></div> @endif
                        <label for="helpInputTop">Logo Favicon</label>
                        <input wire:model="favicon" type="file" class="form-control" id="helpInputTop">
                        <div wire:loading wire:target="favicon">Uploading...</div>
                        @error('favicon') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Site</label>
                <textarea wire:model="desc_site" class="form-control" id="exampleFormControlTextarea1" rows="5">{{$desc_site}}</textarea>
                @error('desc_site') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            <h6 class="mt-4 pt-4">LMW STORE Contact Setting</h6>
            <hr>
            <div class="form-group mb-3">
                <label for="inputNama">Whatsapp Site Admin (gunakan 62 eg.6289123423)</label>
                <input wire:model="wa_admin" type="number" class="form-control no-arrow" id="inputNama" value="{{$wa_admin}}">
                @error('wa_admin') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group mb-3">
                <label for="inputNama">Email Receiver Website</label>
                <input wire:model="webmail" type="email" class="form-control no-arrow" id="inputNama" value="{{$webmail}}">
                @error('webmail') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Alamat LMW Store</label>
                <textarea wire:model="address" class="form-control" id="exampleFormControlTextarea1" rows="5">{{$address}}</textarea>
                @error('address') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Link Google Maps LMW Store</label>
                <textarea wire:model="gmaps" class="form-control" id="exampleFormControlTextarea1" rows="5">{{$gmaps}}</textarea>
                @error('gmaps') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
        </form>
    </div>

</div>
