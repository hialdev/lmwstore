<div>

    <header class='mb-3'>
        <nav class="navbar navbar-expand navbar-light ">
            <div class="container-fluid">
                <a href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3"></i>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown me-1">
                            <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class='bi bi-envelope bi-sub fs-4'></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-center dropdown-menu-md-end" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <h6 class="dropdown-header">Mail</h6>
                                </li>
                                @foreach ($email as $mail)
                                <li>
                                    <div class="dropdown-item d-flex align-items-center gap-2" style="max-width: 18em;">
                                        <div class="p-2 bg-light-danger text-danger rounded-circle">
                                            <span class="iconify" data-icon="ion:mail" style="width: 2em;height:2em"></span>
                                        </div>
                                        <div class="w-100">
                                            <h6 class="m-0">{{ \Illuminate\Support\Str::limit($mail->subject, $limit = 20, $end = '..') }}</h6>
                                            <div class="text-secondary"><small>{{$mail->email}}</small></div>
                                            <small>{{$mail->created_at}}</small>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                <li class="mt-1"><a class="btn-sm btn-primary py-2 w-100 d-block text-center" href="{{route('dash.email')}}">Lihat Semua ></a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-menu d-flex">
                                <div class="user-name text-end me-3">
                                    <h6 class="mb-0 text-gray-600">{{$user->name}}</h6>
                                    <p class="mb-0 text-sm text-gray-600">{{$user->getRoleNames()[0]}}</p>
                                </div>
                                <div class="user-img d-flex align-items-center">
                                    <div class="avatar avatar-md">
                                        <img src="{{isset($user->image)?asset('storage/'.$user->image):'https://ui-avatars.com/api/?name='.$user->name.'&background=0D8ABC&color=fff'}}">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                            <li><a class="dropdown-item" href="{{route('dash.profile')}}"><i class="icon-mid bi bi-person me-2"></i> My
                                    Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#" wire:click="logout"><span class="iconify" data-icon="majesticons:logout"></span> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</div>
