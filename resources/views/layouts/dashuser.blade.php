<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- meta essential --}}
    {!! SEO::generate() !!}

    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/lmw-logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/lmw-logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/lmw-logo.png">
    <link rel="shortcut icon" href="/assets/images/lmw-logo.png">
    <meta name="apple-mobile-web-app-title" content="LMW Store">
    <meta name="application-name" content="LMW Store">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/dashboard/assets/css/bootstrap.css">
    
    <link rel="stylesheet" href="/dashboard/assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="/dashboard/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/dashboard/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/dashboard/assets/css/app.css">

    @stack('style')

    @livewireStyles
</head>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            @livewire('dash.user.header')
            <div class="content-wrapper container">
                
                @yield('body')

            </div>

            <footer>
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>{{\Carbon\Carbon::now()->format('Y')}} &copy; PT Langgeng Makmur Wijaya</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="http://hialdev.com">Hi Aldev</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="/dashboard/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/dashboard/assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="/dashboard/assets/js/pages/dashboard.js"></script>
    <script src="/dashboard/assets/js/pages/horizontal-layout.js"></script>
    <script src="https://code.iconify.design/2/2.1.2/iconify.min.js"></script>
    @stack('script')

    @livewireScripts
</body>

</html>
