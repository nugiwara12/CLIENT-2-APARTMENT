<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MABALACAT DORM: A WEB APPLICATION FOR ENHANCED TENANT MONITORING AND MANAGEMENT') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('admin_assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/templatemo-villa-agency.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/animate.css')}}">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    @yield('styles')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- ***** Header Area Start ***** -->
    <!-- Navbar  -->
    <div class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="/" class="logo">
                            <h1>APARTMENT</h1>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">HOME</a></li>
                            <li><a href="{{ route('booking.forms') }}" class="{{ request()->is('booking-forms') ? 'active' : '' }}">RENT APARTMENT</a></li>
                            <li><a href="{{ route('nav-contents.about_us') }}" class="{{ request()->is('nav-contents.about_us') ? 'active' : '' }}">ABOUT US</a></li>
                            <li><a href="{{ route('nav-contents.contactus') }}" class="{{ request()->is('nav-contents-contactus') ? 'active' : '' }}">CONTACT US</a></li>
                            <li><a href="#" class="{{ request()->is('signin') ? 'active' : '' }}"><i class="bi bi-person-circle"></i>SIGN IN</a></li>
                        </ul>   
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content  -->
    @yield('contents')

    <!-- End of Main Content  -->

    <!-- Footer  -->

    <div class="tap-to-top">
        <a href="#page-top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
    <div class="bg-overlay"></div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- Scripts -->
    <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin_assets/assets/js/isotope.min.js')}}"></script>
    <script src="{{ asset('admin_assets/assets/js/owl-carousel.js')}}"></script>
    <script src="{{ asset('admin_assets/assets/js/counter.js')}}"></script>
    <script src="{{ asset('admin_assets/assets/js/custom.js')}}"></script>
    @yield('scripts')
</body>
</html>