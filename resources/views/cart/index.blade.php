@extends('layouts.app')

@section('content')
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
            @if(!empty($viewData['cartProducts']) && count($viewData['products']) > 0)
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="cart-items">
                            @foreach($viewData['products'] as $product)
                                <div class="cart-item mb-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="product-image-small">
                                                @if($product->getImage())
                                                    <img src="{{ $product->getImage() }}" alt="{{ $product->getName() }}" class="img-fluid rounded">
                                                @else
                                                    <div class="placeholder-image-small">
                                                        <i class="fas fa-leaf"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="mb-1">{{ $product->getName() }}</h6>
                                            <p class="text-muted small mb-0">{{ Str::limit($product->getDescription(), 60) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="price">${{ number_format($product->getPrice(), 2) }}</span>
                                        </div>
                                        <div class="col-md-2">
                                            <span>x {{ $viewData['cartProducts'][$product->getId()] }}</span>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <div class="d-flex flex-column align-items-end">
                                                <form action="{{ route('cart.remove') }}" method="POST" class="mt-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="productId" value="{{ $product->getId() }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ __('Order Summary') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Subtotal') }}</span>
                                        <span>${{ number_format($viewData['subtotal'], 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Shipping') }}</span>
                                        <span>${{ number_format($viewData['shipping'], 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Tax') }}</span>
                                        <span>${{ number_format($viewData['tax'], 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>{{ __('Total') }}</strong>
                                        <strong class="text-success">${{ number_format($viewData['total'], 2) }}</strong>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <form action="{{ route('orders.success') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                                                <i class="fas fa-credit-card me-2"></i>{{ __('Buy') }}
                                            </button>
                                        </form>
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-arrow-left me-2"></i>{{ __('Continue Shopping') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="text-center py-5">
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted">{{ __('Your cart is empty') }}</h3>
                        <p class="text-muted">{{ __('Add some products to get started') }}</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary-custom mt-3">
                            <i class="fas fa-shopping-bag me-2"></i>{{ __('Start Shopping') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
