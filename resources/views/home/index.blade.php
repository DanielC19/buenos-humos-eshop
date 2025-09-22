@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold mb-4">{{ __('Welcome to Buenos Humos') }}</h1>
                        <p class="lead mb-4">{{ __('Your trusted smoke shop with the best smoking products and accessories. Premium quality, fair prices, and fast shipping.') }}</p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="#" class="btn btn-primary-custom">
                                <i class="fas fa-shopping-bag me-2"></i>{{ __('See Products') }}
                            </a>
                            <a href="#" class="btn btn-outline-custom">
                                <i class="fas fa-info-circle me-2"></i>{{ __('Learn More') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="Buenos Humos Logo" class="astronaut-logo">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center section-title">{{ __('Our Categories') }}</h2>
            <div class="row">
                @if(isset($viewData['categories']) && $viewData['categories']->count() > 0)
                    @foreach($viewData['categories']->take(4) as $category)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-{{ $category->getIcon() ?? 'leaf' }}"></i>
                            </div>
                            <h5>{{ $category->getName() }}</h5>
                            <p class="text-muted">{{ $category->getDescription() }}</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                {{ __('See Products') }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h5>{{ __('Herbs') }}</h5>
                            <p class="text-muted">{{ __('The best selected herbs.') }}</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">{{ __('See Products') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-fire"></i>
                            </div>
                            <h5>{{ __('Accessories') }}</h5>
                            <p class="text-muted">{{ __('Everything you need for the perfect smoke.') }}</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">{{ __('See Products') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-smoking"></i>
                            </div>
                            <h5>{{ __('Pipes') }}</h5>
                            <p class="text-muted">{{ __('The best pipes for a smooth smoke.') }}</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">{{ __('See Products') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-cannabis"></i>
                            </div>
                            <h5>{{ __('Vaporizers') }}</h5>
                            <p class="text-muted">{{ __('The best vaporizers for a smooth experience.') }}</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">{{ __('See Products') }}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title">{{ __('Featured Products') }}</h2>
            <div class="row">
                @if(isset($viewData['products']) && $viewData['products']->count() > 0)
                    @foreach($viewData['products']->take(4) as $product)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="product-card">
                            <div class="product-image">
                                @if($product->getImage())
                                    <img src="{{ asset('storage/' . $product->getImage()) }}" alt="{{ $product->getName() }}" class="img-fluid">
                                @else
                                    <i class="fas fa-leaf"></i>
                                @endif
                            </div>
                            <div class="p-3">
                                <h6>{{ $product->getName() }}</h6>
                                <p class="text-muted small">{{ Str::limit($product->getDescription(), 60) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">${{ number_format($product->getPrice(), 2) }}</span>
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary-custom">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @for($i = 1; $i <= 4; $i++)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="product-card">
                            <div class="product-image">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div class="p-3">
                                <h6>{{ __('Featured Product') }} {{ $i }}</h6>
                                <p class="text-muted small">{{ __('Description of the featured product') }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">${{ number_format(rand(10, 100), 2) }}</span>
                                    <button class="btn btn-sm btn-primary-custom">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary-custom">
                    {{ __('All Products') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h5>{{ __('Fast Shipping') }}</h5>
                        <p class="text-muted">{{ __('Get your products delivered fast and on time.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>{{ __('Safe Purchase') }}</h5>
                        <p class="text-muted">{{ __('Shop with confidence and enjoy a safe purchase experience.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h5>{{ __('Premium Quality') }}</h5>
                        <p class="text-muted">{{ __('Only the best products.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5>{{ __('Support') }}</h5>
                        <p class="text-muted">{{ __('Customer service available.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection