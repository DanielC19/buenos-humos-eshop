@extends('layouts.app')

@section('content')
    <!-- Category Header Section -->
    <section class="hero-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold mb-4">{{ $viewData['category']->getName() }}</h1>
                        <p class="lead mb-4">{{ $viewData['category']->getDescription() }}</p>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-primary-custom fs-6">
                                {{ count($viewData['products']) }} {{ __('Products Available') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center">
                        @if ($viewData['category']->getBanner())
                            <img src="{{ $viewData['category']->getBanner() }}" alt="Buenos Humos Logo" class="astronaut-logo">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            @if(count($viewData['products']) > 0)
                <div class="row">
                    @foreach($viewData['products'] as $product)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="product-card">
                                <a href="{{ route('products.show', $product->getId()) }}">
                                    <div class="product-image">
                                        @if($product->getImage())
                                            <img src="{{ $product->getImage() }}" alt="{{ $product->getName() }}" class="img-fluid">
                                        @else
                                            <i class="fas fa-leaf"></i>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h6>{{ $product->getName() }}</h6>
                                        <p class="text-muted small">{{ $product->getDescription() }}</p>
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
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            {{ $viewData['products']->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted">{{ __('No Products Found') }}</h3>
                        <p class="text-muted">{{ __('This category doesn\'t have products.') }}</p>
                        <a href="{{ route('home.index') }}" class="btn btn-primary-custom mt-3">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Home') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
