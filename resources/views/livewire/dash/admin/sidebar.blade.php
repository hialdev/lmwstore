<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{route('home')}}" target="_blank"><img src="/assets/images/lmw-logo.png" alt="Logo" style="height: 2em"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li
                    class="sidebar-item {{request()->is('canting') ? 'active' : ''}}">
                    <a href="{{route('dash.index')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-title">Products Management</li> <!-- Title -->
                <li
                    class="sidebar-item {{request()->is('canting/brand') ? 'active' : ''}}">
                    <a href="{{route('dash.brand')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="fa-solid:shapes"></span>
                        <span>Brands</span>
                    </a>
                </li>
                <li
                    class="sidebar-item has-sub {{request()->is('canting/product*') ? 'active' : ''}}">
                    <a href="#" class='sidebar-link'>
                        <span class="iconify" data-icon="fa-solid:tshirt"></span>
                        <span>Products</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{route('dash.product')}}">Lihat Products</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('dash.product.add')}}">Tambah Products</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/category*') ? 'active' : ''}}">
                    <a href="{{route('dash.category')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="ion:pricetags"></span>
                        <span>Kategori Products</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/label*') ? 'active' : ''}}">
                    <a href="{{route('dash.label')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="bxs:label"></span>
                        <span>Label Products</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/coupon*') ? 'active' : ''}}">
                    <a href="{{route('dash.coupon')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="ri:coupon-3-fill"></span>
                        <span>Coupon</span>
                    </a>
                </li>
                <li class="sidebar-title">Order Management</li> <!-- Title -->
                <li
                    class="sidebar-item {{request()->is('canting/pesanan*') ? 'active' : ''}}">
                    <a href="{{route('dash.pesanan')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="fluent:clipboard-task-list-ltr-24-filled"></span>
                        <span>Pesanan</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/bank') ? 'active' : ''}}">
                    <a href="{{route('dash.bank')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="bi:credit-card-2-back-fill"></span>
                        <span>Bank</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/users*') ? 'active' : ''}}">
                    <a href="{{route('dash.users')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="fa:group"></span>
                        <span>Users</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/email*') ? 'active' : ''}}">
                    <a href="{{route('dash.email')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="mdi:email-multiple"></span>
                        <span>Emails</span>
                    </a>
                </li>
                <li class="sidebar-title">Content Management</li> <!-- Title -->
                <li
                    class="sidebar-item has-sub {{request()->is('canting/banner*') ? 'active' : ''}}">
                    <a href="{{route('dash.banner')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="ooui:image-gallery"></span>
                        <span>Banners</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{route('dash.banner')}}">Banner Homepage</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('dash.banner.custom')}}">Banner Custom</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/value*') ? 'active' : ''}}">
                    <a href="{{route('dash.value')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="bi:check-circle-fill"></span>
                        <span>Values</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/faq*') ? 'active' : ''}}">
                    <a href="{{route('dash.faq')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="akar-icons:chat-question"></span>
                        <span>FAQs</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/contact*') ? 'active' : ''}}">
                    <a href="{{route('dash.contact')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="fluent:contact-card-32-filled"></span>
                        <span>Contacts</span>
                    </a>
                </li>
                <li class="sidebar-title">Site Management</li> <!-- Title -->
                <li
                    class="sidebar-item has-sub {{request()->is('canting/meta*') ? 'active' : ''}}">
                    <a href="#" class='sidebar-link'>
                        <span class="iconify" data-icon="uis:web-grid-alt"></span>
                        <span>Meta Pages</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{route('dash.page')}}">Pages</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('dash.seo')}}">SEO Metatools</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item {{request()->is('canting/pengaturan*') ? 'active' : ''}}">
                    <a href="{{route('dash.pengaturan')}}" class='sidebar-link'>
                        <span class="iconify" data-icon="ant-design:setting-filled"></span>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
