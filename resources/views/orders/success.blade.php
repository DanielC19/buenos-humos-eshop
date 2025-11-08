@extends('layouts.app')

@section('content')
    <!-- Success Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <i class="fas fa-check-circle fa-4x text-success mb-4"></i>
                    <h1 class="h2 text-success mb-3">{{ __('Order Successful!') }}</h1>
                    <p class="lead text-muted mb-4">{{ __('Thank you for your purchase. Your order has been confirmed and is being processed.') }}</p>

                    <!-- Order Info -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row text-start">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Order Number:') }}</strong><br>
                                    <span class="text-muted">#{{ $viewData['order']->getId() }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Order Date:') }}</strong><br>
                                    <span class="text-muted">{{ date('F j, Y') }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Total Amount:') }}</strong><br>
                                    <span class="text-success fw-bold">${{ number_format($viewData['order']->getTotal(), 2) }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Status:') }}</strong><br>
                                    <span class="badge bg-success">{{ __('Paid') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- What's Next -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('What happens next?') }}</h5>
                        </div>
                        <div class="card-body text-start">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                        <h6>{{ __('Confirmed') }}</h6>
                                        <small class="text-muted">{{ __('Order received') }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-box text-muted fa-2x mb-2"></i>
                                        <h6>{{ __('Processing') }}</h6>
                                        <small class="text-muted">{{ __('Preparing items') }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-truck text-muted fa-2x mb-2"></i>
                                        <h6>{{ __('Shipped') }}</h6>
                                        <small class="text-muted">{{ __('On the way') }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-home text-muted fa-2x mb-2"></i>
                                        <h6>{{ __('Delivered') }}</h6>
                                        <small class="text-muted">{{ __('Enjoy!') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex flex-wrap justify-content-center gap-3 mb-3">
                        <a href="{{ route('products.index') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>{{ __('Continue Shopping') }}
                        </a>
                        <a href="{{ route('home.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-home me-2"></i>{{ __('Back to Home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
