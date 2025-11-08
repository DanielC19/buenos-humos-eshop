@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <!-- Simple Search and Filter -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('products.index', request()->all()) }}" class="d-flex">
                        <input type="text" class="form-control" name="search" placeholder="{{ __('Search products...') }}" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary-custom ms-2">{{ __('Search') }}</button>
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('products.index', ['mostSold' => !request('mostSold')] + request()->all()) }}"
                       class="btn {{ request('mostSold') ? 'btn-primary-custom' : 'btn-outline-custom' }}">
                        {{ __('Most Sold') }}
                    </a>
                </div>
            </div>

            @if(count($viewData['products']) > 0)
                <div class="row">
                    @foreach($viewData['products'] as $product)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="product-card">
                                <a href="{{ route('products.show', $product->getId()) }}">
                                    <div class="product-image">
                                        @if($product->getImage())
                                            <img src="{{ asset('storage/' . $product->getImage()) }}" alt="{{ $product->getName() }}" class="img-fluid">
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
                        <p class="text-muted">{{ __('Try adjusting your search or filter settings.') }}</p>
                        <a href="{{ route('home.index') }}" class="btn btn-primary-custom mt-3">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Home') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
