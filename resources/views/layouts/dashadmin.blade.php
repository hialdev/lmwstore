<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruangan Admin - LMW Store</title>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/dashboard/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/dashboard/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/dashboard/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/dashboard/assets/css/app.css">
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

    <style>
        .no-arrow::-webkit-outer-spin-button,
        .no-arrow::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }
        
        .no-arrow[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }
        .dropdown-menu-center {
            right: auto;
            left: 50%;
            -webkit-transform: translate(-50%, 0);
            -o-transform: translate(-50%, 0);
            transform: translate(-50%, 0);
        }
    </style>
    @stack('style')
    
    @livewireStyles

</head>

<body>
    <div id="app">
        @livewire('dash.admin.sidebar')
        <div id="main" class='layout-navbar'>
            @livewire('dash.admin.header')
            <div class="container-fluid p-md-4">
                
                @yield('body')

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>{{\Carbon\Carbon::now()->format('Y')}} &copy; PT Langgeng Makmur Wijaya</p>
                        </div>
                        <div class="float-end">
                            <p>Made with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                                by <a href="https://hialdev.com">hialdev</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/dashboard/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.iconify.design/2/2.1.2/iconify.min.js"></script>
    <script src="/dashboard/assets/js/mazer.js"></script>

    @stack('script')

    @livewireScripts
</body>

</html>
