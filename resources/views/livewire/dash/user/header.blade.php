<div>
    @php
        $set = \App\Models\Setting::all()->keyBy('key');
    @endphp
    <header class="mb-5">
        <div class="header-top">
            <div class="container">
                <div class="logo">
                    <a href="{{route('home')}}"><img src="{{$set->get('logo_site') !== null? asset('storage'.$set->get('logo_site')->content) :'/assets/images/lmw-logo.png'}}" alt="Logo" style="height: 4em"></a>
                </div>
                <div class="header-top-right">

                    <div class="dropdown">
                        <a href="#" class="user-dropdown d-flex dropend" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar avatar-md2" >
                                <img src="{{isset($user->image)?asset('storage/'.$user->image):'https://ui-avatars.com/api/?name='.$user->name.'&background=0D8ABC&color=fff'}}" alt="Avatar" style="object-fit: cover">
                            </div>
                            <div class="text">
                                <h6 class="user-dropdown-name">{{$user->name}}</h6>
                                <p class="user-dropdown-status text-sm text-muted">{{$user->email}}</p>
                            </div>
                        </a>
                    </div>

                    <!-- Burger button responsive -->
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </div>
            </div>
        </div>
        <nav class="main-navbar bg-white border-top">
            <div class="container">
                <ul>
                    <li class="menu-item">
                        <a href="{{route('order.pending')}}" class="menu-link {{request()->is('transaksi-pending*') ? 'text-dark fw-bold' : 'text-secondary'}}">
                            <span class="iconify" data-icon="ic:outline-pending-actions"></span>
                            <span>Transaksi Pending</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('order.sukses')}}" class="menu-link {{request()->is('transaksi-sukses*') ? 'text-dark fw-bold' : 'text-secondary'}}">
                            <span class="iconify" data-icon="icon-park-outline:transaction-order"></span>
                            <span>Transaksi Success</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('profile')}}" class="menu-link {{request()->is('profile*') ? 'text-dark fw-bold' : 'text-secondary'}}">
                            <span class="iconify" data-icon="gg:profile"></span>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li class="menu-item ms-auto">
                        <a href="{{route('cart')}}" class='menu-link text-dark'>
                            <span class="iconify" data-icon="akar-icons:cart"></span>
                            <span class="badge bg-primary text-white ">{{$count}}</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a wire:click="logout" class='menu-link text-danger' style="cursor: pointer">
                            <span class="iconify" data-icon="majesticons:logout"></span>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

    </header>
</div>
