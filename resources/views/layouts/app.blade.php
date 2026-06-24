<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'সাজ-পাৰ') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body{
            margin:0;
            padding:0;
        }
    </style>
</head>

<body>
<div id="app">

    {{-- Hide Navbar on Login & Register Pages --}}
    @if(!Request::is('login') && !Request::is('register'))

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'সাজ-পাৰ') }}
                </a>

                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">

                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse"
                     id="navbarSupportedContent">

                    <!-- Left Side -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto">

                        @guest

                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('login') }}">
                                        Login
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('register') }}">
                                        Register
                                    </a>
                                </li>
                            @endif

                        @else

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown"
                                   class="nav-link dropdown-toggle"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false"
                                   v-pre>

                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end"
                                     aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item"
                                       href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">

                                        Logout
                                    </a>

                                    <form id="logout-form"
                                          action="{{ route('logout') }}"
                                          method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>

                                </div>

                            </li>

                        @endguest

                    </ul>

                </div>

            </div>
        </nav>

    @endif

    <main>
        @yield('content')
    </main>

</div>
</body>
</html>