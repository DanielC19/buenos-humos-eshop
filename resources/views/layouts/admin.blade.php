<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ __('Admin') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <!-- Admin Header -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.index') }}">
                <i class="fas fa-shield-alt me-2"></i>{{ __('Admin Panel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.index') }}" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i>{{ __('View Site') }}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->getName() }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <a class="dropdown-item" href="{{ route('home.index') }}">
                                <i class="fas fa-home me-2"></i>{{ __('Go to Home') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="admin-wrapper">
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                </h5>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>{{ __('Overview') }}</span>
                </a>

                <div class="sidebar-divider">
                    <span>{{ __('Catalog') }}</span>
                </div>

                <a href="{{ route('admin.product-categories.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i>
                    <span>{{ __('Categories') }}</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span>{{ __('Products') }}</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>{{ __('Oops! There were some errors:') }}</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <footer class="admin-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ __('Buenos Humos') }}. {{ __('All rights reserved.') }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <small class="text-muted">{{ __('Version') }} 1.0.0</small>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
