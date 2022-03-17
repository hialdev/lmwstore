<div>

    <header class="header header-7">
        <div class="header-top">
            <div class="container-fluid py-3">
                <div class="header-left">
                    <ul class="top-menu">
                        <li>
                            <a href="#">Instagram</a>
                            <ul>
                                <li><a href=""><span class="iconify mr-2" data-icon="fontisto:instagram"></span> Elemwe</a></li>
                                <li><a href=""><span class="iconify mr-2" data-icon="fontisto:instagram"></span> Batik Tambora</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- End .header-left -->

                <div class="header-right">
                    <ul class="top-menu">
                        <li>
                            <a href="#">Store</a>
                            <ul>
                                <li><a href="tel:#"><i class="icon-phone"></i>Call/WA: +0123 456 789</a></li>
                                <li><a href="#"><span class="iconify mr-3" data-icon="lucide:map-pin"></span>Jl. Rawamangun berapa gitu ya, Jakarta Timur.</a></li>
                            </ul>
                        </li>
                    </ul><!-- End .top-menu -->
                </div><!-- End .header-right -->
            </div><!-- End .container-fluid -->
        </div><!-- End .header-top -->

        <div class="header-middle sticky-header">
            <div class="container-fluid">
                <div class="header-left">
                    <button class="mobile-menu-toggler">
                        <span class="sr-only">Toggle mobile menu</span>
                        <i class="icon-bars"></i>
                    </button>
                    
                    <a href="{{url('/')}}" class="logo">
                        <img src="/assets/images/lmw-logo.png" alt="Molla Logo" width="105" height="25">
                    </a>

                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            
                            <li class="{{request()->is('brand*') ? 'active' : ''}}">
                                <a href="#" class="sf-with-ul">Brand</a>

                                <ul>
                                    @foreach ($brands as $brand)
                                    <li class="border-bottom"><a href="{{route('product.brand',$brand->slug)}}"><img src="{{$brand->image}}" style="max-height: 4em;" class="mx-auto d-block" alt="{{$brand->name}}"></a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="{{request()->is('product*') ? 'active' : ''}}">
                                <a href="{{route('product')}}" class="pr-3">Product</a>
                            </li>
                            <li class="{{request()->is('contact') ? 'active' : ''}}">
                                <a href="{{route('contact')}}" class="pr-3">Contact</a>
                            </li>
                            <li class="{{request()->is('faq') ? 'active' : ''}}">
                                <a href="{{route('faq')}}" class="pr-3">Faqs</a>
                            </li>
                        </ul><!-- End .menu -->
                    </nav><!-- End .main-nav -->
                </div><!-- End .header-left -->

                @livewire('cart-log')
            </div><!-- End .container-fluid -->
            <div class="categories-tab border-top">
                <div class="d-flex w-100 align-items-center">
                    @foreach ($categories as $cat)
                    <a href="{{route('product.category',$cat->slug)}}" class="p-4 px-5 cat-item {{request()->is('category/'.$cat->slug) ? 'active' : ''}}">{{str_replace(' ','',$cat->name)}}</a>
                    @endforeach
                </div>  
            </div>
        </div><!-- End .header-middle -->
    </header><!-- End .header -->
    

</div>
