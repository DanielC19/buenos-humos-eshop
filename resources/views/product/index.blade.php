@extends('layouts.app')

@section('content')
    <!-- Products Header Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3">{{ __('Our Products') }}</h1>
                <p class="lead text-muted">{{ __('Discover our complete collection of premium smoking products and accessories') }}</p>
            </div>
        </div>
    </section>

    <!-- Products Grid Section -->
    <section class="py-5">
        <div class="container">
            @if($viewData['products']->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-box-open fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted">{{ __('No products found') }}</h3>
                    <p class="text-muted">{{ __('Check back later for new products or contact us for special requests.') }}</p>
                </div>
            @else
                <div class="row">
                    @foreach($viewData['products'] as $product)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="product-card h-100">
                                <div class="product-image">
                                    @if($product->getImage())
                                        <img src="{{ asset('storage/' . $product->getImage()) }}" alt="{{ $product->getName() }}" class="img-fluid">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-leaf fa-3x text-muted"></i>
                                        </div>
                                    @endif

                                    <!-- Stock Badge -->
                                    @if($product->getStock() <= 0)
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-danger">{{ __('Out of Stock') }}</span>
                                        </div>
                                    @elseif($product->getStock() <= 5)
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-warning">{{ __('Low Stock') }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-3 d-flex flex-column">
                                    <h6 class="fw-bold mb-2">{{ $product->getName() }}</h6>

                                    @if($product->getBrand())
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-tag me-1"></i>{{ $product->getBrand() }}
                                        </p>
                                    @endif

                                    <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($product->getDescription(), 80) }}</p>

                                    <!-- Category -->
                                    @if($product->productCategory)
                                        <div class="mb-2">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $product->productCategory->name }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Price and SKU -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="price fw-bold text-success">${{ number_format($product->getPrice() / 100, 2) }}</span>
                                        <small class="text-muted">SKU: {{ $product->getSku() }}</small>
                                    </div>

                                    <!-- Stock Info -->
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-box me-1"></i>
                                            @if($product->getStock() > 0)
                                                <span class="text-success">{{ $product->getStock() }} {{ __('in stock') }}</span>
                                            @else
                                                <span class="text-danger">{{ __('Out of stock') }}</span>
                                            @endif
                                        </small>
                                    </div>

                                    <!-- Add to Cart Button -->
                                    <div class="mt-auto">
                                        @if($product->getStock() > 0)
                                            <form action="#" method="POST" class="w-100">
                                                @csrf
                                                <button type="submit" class="btn btn-primary-custom w-100">
                                                    <i class="fas fa-cart-plus me-2"></i>{{ __('Add to Cart') }}
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-outline-secondary w-100" disabled>
                                                <i class="fas fa-times me-2"></i>{{ __('Out of Stock') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination or Load More -->
                <div class="text-center mt-5">
                    <p class="text-muted">{{ __('Showing') }} {{ $viewData['products']->count() }} {{ __('products') }}</p>
                </div>
            @endif
        </div>
    </section>
@endsection
