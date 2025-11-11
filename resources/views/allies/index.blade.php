@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h1 class="display-4 mb-3">{{ __('Our Allies') }}</h1>
                    <p class="lead text-muted">
                        {{ __('Discover products from our trusted partner suppliers. We collaborate with the best in the industry to bring you a wider selection of quality products.') }}
                    </p>
                </div>
            </div>

            @if(count($viewData['suppliers']) > 0)
                @foreach($viewData['suppliers'] as $supplier)
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-4">
                            <div>
                                <h3 class="mb-1">{{ $supplier['name'] ?? __('Supplier') }}</h3>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-envelope me-2"></i>{{ $supplier['email'] ?? '' }}
                                </p>
                            </div>
                        </div>

                        @if(isset($supplier['provided_drugs']) && count($supplier['provided_drugs']) > 0)
                            <div class="row">
                                @foreach($supplier['provided_drugs'] as $product)
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="product-card">
                                            <a href="{{ $product['purchase_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                                <div class="product-image">
                                                    @if(isset($product['image_url']) && $product['image_url'])
                                                        <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] ?? __('Product') }}" class="img-fluid">
                                                    @else
                                                        <i class="fas fa-leaf"></i>
                                                    @endif
                                                </div>
                                                <div class="p-3">
                                                    <h6>{{ $product['name'] ?? __('Product') }}</h6>
                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        @if(isset($product['price']))
                                                            <span class="price">${{ number_format($product['price'], 0, ',', '.') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-building me-1"></i>{{ $supplier['name'] }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">{{ __('No products available from this supplier.') }}</p>
                        @endif
                    </div>
                    @if(!$loop->last)
                        <hr class="my-5">
                    @endif
                @endforeach
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-handshake fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted">{{ __('No Ally Products Available') }}</h3>
                        <p class="text-muted">{{ __('Check back later for products from our partners.') }}</p>
                        <a href="{{ route('home.index') }}" class="btn btn-primary-custom mt-3">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Home') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
