<div>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container bg-white">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form wire:submit.prevent="search" method="get">
                <div class="mobile-search">
                    <input wire:model="qmobile" type="search" class="form-control bg-light border-bottom text-dark" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                </div>
            </form>

            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active">
                        <a href="#">Categories</a>
                        <ul>
                            @foreach ($category as $ctg)
                            <li><a href="{{route('product.category',$ctg->slug)}}">{{$loop->index+1 .' - '.$ctg->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="#">Brands</a>
                        <ul>
                            @foreach ($brands as $brand)
                            <li><a href="{{route('product.brand',$brand->slug)}}">{{$brand->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('contact')}}">Contact</a>
                    </li>
                    <li>
                        <a href="{{route('faq')}}">Faqs</a>
                    </li>
                    {{-- @guest --}}
                    <li class="mt-2">
                        <a href="{{route('login')}}" class="btn btn-primary text-white">Login</a>
                    </li>
                    {{-- @endguest --}}
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                @foreach ($contacts as $c) 
                    <a href="{{$c->url}}" class="social-icon" target="_blank" title="{{$c->platform}}"><span class="iconify" data-icon="{{$c->icon}}"></span></a>
                @endforeach
            </div><!-- End .soial-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
    
</div>
