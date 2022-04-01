<div>

    <header class="header header-7">

        <div class="header-middle sticky-header">
            <div class="container-fluid">
                <div class="header-left">
                    <button class="mobile-menu-toggler">
                        <span class="sr-only">Toggle mobile menu</span>
                        <i class="icon-bars"></i>
                    </button>
                    @php
                        $set = \App\Models\Setting::all()->keyBy('key');
                    @endphp
                    <a href="{{url('/')}}" class="logo">
                        <img src="{{$set->get('logo_site') !== null? asset('storage'.$set->get('logo_site')->content) :'/assets/images/lmw-logo.png'}}" alt="Molla Logo" style="height:3.4em">
                    </a>

                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            
                            <li class="{{request()->is('brand*') ? 'active' : ''}}">
                                <a href="#" class="sf-with-ul">Brand</a>

                                <ul>
                                    @foreach ($brands as $brand)
                                    <li class="border-bottom"><a href="{{route('product.brand',$brand->slug)}}"><img src="{{asset('storage'.$brand->image)}}" style="max-height: 4em;" class="mx-auto d-block" alt="{{$brand->name}}"></a></li>
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
                    <a href="{{route('product.category',$cat->slug)}}" class="p-4 px-5 cat-item {{request()->is('category/'.$cat->slug) ? 'active' : ''}}" style="white-space: nowrap;">{{$cat->name}}</a>
                    @endforeach
                </div>  
            </div>
        </div><!-- End .header-middle -->
    </header><!-- End .header -->
    

</div>
