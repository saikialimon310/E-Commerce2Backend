<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon"/>

    

    <style>
    html, body {
        height: auto !important;
        overflow: auto !important;
    }

    .wrapper {
        overflow: visible !important;
    }

    .main-panel {
        height: auto !important;
        max-height: none !important;
        overflow-y: auto !important;
    }
    </style>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
</head>

<body>
<div class="wrapper">

    @include('layouts.sidebar')

    <div class="main-panel d-flex flex-column" 
        style="min-height:100vh; overflow-y:auto; max-height:100vh;">
        <div class="main-header">

            {{-- <div class="logo-header" data-background-color="dark">
                <a href="#" class="logo">
                    <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" height="20">
                </a>
            </div> --}}

            <nav class="navbar navbar-expand-lg border-bottom">
                <div class="container-fluid">

                    <ul class="navbar-nav ms-auto align-items-center">

                        <!-- ✅ NEW CART MENU (ADDED BEFORE PROFILE) -->
                        <li class="nav-item">
                            <a href="{{ route('carts.index') }}" class="nav-link">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="ms-1">Carts</span>
                            </a>
                        </li>

                        <!-- EXISTING PROFILE (UNCHANGED) -->
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown">
                                <div class="avatar-sm">
                                    <img src="{{ asset('assets/img/profile.jpg') }}" class="avatar-img rounded-circle">
                                </div>
                                <span class="profile-username">
                                    <span class="op-7">Hi,</span>
                                    <span class="fw-bold">Hizrian</span>
                                </span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">My Profile</a>
                                    <a class="dropdown-item" href="#">Settings</a>

                                    <a class="dropdown-item"
                                    href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>

        <!-- Page Content -->
        @yield('content')

        <!-- Footer -->
        <footer class="footer mt-auto">
            <div class="container-fluid d-flex justify-content-between">
                <div class="copyright">
                    2024 © Your Project
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- JS -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>

</body>
</html>