<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home.index') }}">
                <i class="fas fa-rocket me-2"></i>{{ __('Buenos Humos') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.index') }}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product.index') }}">{{ __('Products') }}</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown ms-2">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" onclick="document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-success mb-3">
                        <i class="fas fa-rocket me-2"></i>{{ __('Buenos Humos') }}
                    </h5>
                    <p>{{ __('Your trusted smoke shop with the best products for a premium experience.') }}</p>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">{{ __('Developers') }}</h6>
                    <div class="footer-links">
                        <p class="mb-2"><i class="fas fa-user me-2"></i>{{ __('Daniel Correa') }}</p>
                        <p class="mb-2"><i class="fas fa-user me-2"></i>{{ __('Daniel Arango') }}</p>
                        <p class="mb-2"><i class="fas fa-user me-2"></i>{{ __('Lucas Higuita') }}</p>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ __('Buenos Humos') }}. {{ __('All rights reserved.') }}</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
