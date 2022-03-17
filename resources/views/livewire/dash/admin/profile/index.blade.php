<div>
    
    <h2>My Profile</h2>
    <div class="bg-white my-3 rounded-3 p-3">
        <div class="d-flex flex-column flex-md-row align-items-center gap-3 p-3 w-100">
            <div>
                <img src="{{isset($user->image)?asset('storage/'.$user->image):'https://ui-avatars.com/api/?name='.$user->name.'&background=0D8ABC&color=fff'}}" alt="{{$user->name}} profile image" class="rounded-circle d-block mx-auto" style="width: 12em;height: 12em; object-fit:cover">
            </div>
            <div class="w-100 mt-3">
                <h2>{{$user->name}}</h2>
                @if(isset($user->username))<p class="text-muted d-flex align-items-center gap-3"><span class="iconify" data-icon="bx:bxs-user"></span>{{$user->username}}</p>@endif
                <p class="text-muted d-flex align-items-center gap-3"><span class="iconify" data-icon="feather:mail"></span>{{$user->email}}</p>
                @if(isset($user->phone))<p class="text-muted d-flex align-items-center gap-3"><span class="iconify" data-icon="el:phone"></span>{{$user->phone}}</p>@endif
                <div class="d-flex flex-column flex-md-row gap-3 align-items-start">
                    <button class="w-100 btn btn-primary" wire:click="onUpdate"><span class="iconify" data-icon="bx:bxs-user"></span> Ubah Profil</button>
                    @if($user->password !== '0')<button class="w-100 btn btn-outline-primary" wire:click="onChange"><span class="iconify" data-icon="fontisto:key"></span> Ganti Password</button>@endif
                </div>
            </div>
        </div>
    </div>

    @if ($showUpdate === true)
    <div class="bg-white my-3 rounded-3 p-3">
        <form wire:submit.prevent="updateProfile({{$user->id}})" enctype="multipart/form-data" class="position-relative pt-4">
            <div class="d-flex flex-column flex-md-column flex-lg-row align-items-center gap-4 p-3 w-100">
                <div>
                    <img src="{{ isset($image) ? $image->temporaryUrl() : asset('storage/'.$user->image)}}" alt="{{$user->name}} image profile preview" class="rounded-circle d-block mx-auto" id="image-preview" style="width: 12em;height: 12em; object-fit:cover">
                    
                    <div class="my-3">
                        <input type="file" wire:model="image" id="file-input" class="form-control @error('image') is-invalid @enderror" accept="png,jpg,jpeg">
                    </div>
                </div>
                <div class="w-100">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input wire:model="name" type="text" class="form-control w-100 @error('name') is-invalid @enderror" id="nama" placeholder="Nama">
                        @error('name') <small class="invalid-feedback">{{$message}}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input wire:model="username" type="text" class="form-control w-100 @error('username') is-invalid @enderror" id="username" placeholder="Username">
                        @error('username') <small class="invalid-feedback">{{$message}}</small> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input wire:model="email" type="email" class="form-control w-100 @error('email') is-invalid @enderror" id="email" placeholder="Mail@example.com" {{$user->password === '0' ? 'disabled' : ''}}>
                        @error('email') <small class="invalid-feedback">{{$message}}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no" class="form-label">No Telp</label>
                        <input wire:model="phone" type="number" class="form-control w-100" id="no" placeholder="No Telp / WA">
                        @error('phone') <small class="invalid-feedback">{{$message}}</small> @enderror
                    </div>
                </div>
                <button type="button" wire:click="close" class="d-inline-flex align-items-center gap-3 position-absolute rounded-3 btn btn-light" style="top:0;left:0">
                    <span class="iconify" data-icon="ep:circle-close-filled"></span> Close
                </button>
                <button type="submit" class="d-inline-flex align-items-center gap-3 position-absolute rounded-3 btn btn-primary" style="top:0;right:0">
                    <span class="iconify" data-icon="fa-solid:save"></span> Simpan
                </button>
            </div>
        </form>
    </div>
    @elseif ($showChange === true)
    <div class="bg-white my-3 rounded-3 p-3">
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
        <form wire:submit.prevent="updatePassword({{$user->id}})" class="position-relative pt-5">
            <div class="d-flex flex-column flex-md-column flex-lg-row align-items-center gap-4 p-3 w-100">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Sekarang</label>
                        <input type="password" wire:model="password" class="form-control w-100" id="password" placeholder="Password sekarang">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" wire:model="newpassword" class="form-control w-100" id="password" placeholder="Password baru">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" wire:model="cnewpassword" class="form-control w-100" id="password" placeholder="Konfirmasi password baru">
                    </div>
                </div>
                <button type="button" wire:click="close" class="d-inline-flex align-items-center gap-3 position-absolute rounded-3 btn btn-light" style="top:0;left:0">
                    <span class="iconify" data-icon="ep:circle-close-filled"></span> Close
                </button>
                <button type="submit" class="d-inline-flex align-items-center gap-3 position-absolute rounded-3 btn btn-primary" style="top:0;right:0">
                    <span class="iconify" data-icon="fa-solid:key"></span> Ubah
                </button>
            </div>
        </form>
    </div>
    @endif
    

</div>
