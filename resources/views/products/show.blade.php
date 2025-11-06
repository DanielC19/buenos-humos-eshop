@extends('layouts.app')

@section('content')
    <!-- Product Details -->
    <section class="py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="product-image-large">
                        @if($viewData['product']->getImage())
                            <img src="{{ $viewData['product']->getImage() }}"
                                 alt="{{ $viewData['product']->getName() }}"
                                 class="img-fluid rounded shadow">
                        @else
                            <div class="placeholder-image-large">
                                <i class="fas fa-leaf"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-details">
                        <h1 class="h2 mb-3">{{ $viewData['product']->getName() }}</h1>

                        <div class="price-section mb-4">
                            <span class="price-large">${{ number_format($viewData['product']->getPrice(), 2) }}</span>
                        </div>

                        <div class="description-section mb-4">
                            <h5>{{ __('Description') }}</h5>
                            <p class="text-muted">{{ $viewData['product']->getDescription() }}</p>
                        </div>

                        <!-- Add to Cart Form -->
                        <div class="cart-section mb-4">
                            <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-3">
                                @csrf
                                <div class="quantity-selector">
                                    <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                                </div>
                                <div class="add-to-cart-btn">
                                    <input type="hidden" name="productId" value="{{ $viewData['product']->getId() }}">
                                    <button type="submit" class="btn btn-primary-custom btn-lg">
                                        <i class="fas fa-cart-plus me-2"></i>{{ __('Add to Cart') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Product Features -->
                        <div class="features-section">
                            <div class="row">
                                <div class="col-6">
                                    <div class="feature-item">
                                        <i class="fas fa-shipping-fast text-primary me-2"></i>
                                        <span class="small">{{ __('Fast Shipping') }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item">
                                        <i class="fas fa-shield-alt text-primary me-2"></i>
                                        <span class="small">{{ __('Safe Purchase') }}</span>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="feature-item">
                                        <i class="fas fa-medal text-primary me-2"></i>
                                        <span class="small">{{ __('Premium Quality') }}</span>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="feature-item">
                                        <i class="fas fa-headset text-primary me-2"></i>
                                        <span class="small">{{ __('24/7 Support') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
