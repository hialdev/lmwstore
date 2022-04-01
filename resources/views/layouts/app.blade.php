<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- meta essential --}}
    {!! SEO::generate() !!}

    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- Favicon -->
    @php
        $set = \App\Models\Setting::all()->keyBy('key');
    @endphp
    <link rel="apple-touch-icon" sizes="180x180" href="{{$set->get('logo_favicon') !== null ? asset('storage'.$set->get('logo_favicon')->content) : '/assets/images/lmw-logo.png'}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{$set->get('logo_favicon') !== null ? asset('storage'.$set->get('logo_favicon')->content) : '/assets/images/lmw-logo.png'}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{$set->get('logo_favicon') !== null ? asset('storage'.$set->get('logo_favicon')->content) : '/assets/images/lmw-logo.png'}}">
    <link rel="shortcut icon" href="{{$set->get('logo_favicon') !== null ? asset('storage'.$set->get('logo_favicon')->content): '/assets/images/lmw-logo.png'}}">
    <meta name="apple-mobile-web-app-title" content="LMW Store">
    <meta name="application-name" content="LMW Store">

    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="/assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="/assets/css/plugins/jquery.countdown.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/css/intlTelInput.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/skins/skin-demo-7.css">
    <link rel="stylesheet" href="/assets/css/demos/demo-7.css">

    @stack('style')
    @livewireStyles
</head>

<body>
    
    <div class="page-wrapper">
        
        @livewire('header')
        <main class="main">
            
            @yield('content');
            {{isset($slot)?$slot:null}}    
        </main><!-- End .main -->
        @livewire('footer')

    </div><!-- End .page-wrapper -->

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    @livewire('mobile-menu')

    <!-- Plugins JS File -->
    <script src="https://code.iconify.design/2/2.1.2/iconify.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/jquery.hoverIntent.min.js"></script>
    <script src="/assets/js/jquery.waypoints.min.js"></script>
    <script src="/assets/js/superfish.min.js"></script>
    <script src="/assets/js/bootstrap-input-spinner.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/jquery.plugin.min.js"></script>
    <script src="/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/js/jquery.countdown.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/js/intlTelInput.js"></script>
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/demos/demo-7.js"></script>

    @stack('script')

    @livewireScripts
</body>


</html>