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
                                    @if($viewData['order']->getStatus() === 'confirmed')
                                        <span class="badge bg-success">{{ __('Paid') }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ __('Pending Payment') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Payment Method:') }}</strong><br>
                                    @if($viewData['order']->getPaymentMethod() === 'balance')
                                        <span class="text-muted"><i class="fas fa-wallet me-1"></i>{{ __('Account Balance') }}</span>
                                    @else
                                        <span class="text-muted"><i class="fas fa-file-invoice me-1"></i>{{ __('Invoice Generated') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    @if($viewData['order']->getStatus() === 'confirmed')

                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>{{ __('Payment Successful') }}</h5>
                            </div>
                            <div class="card-body">
                                @if ($viewData['order']->getPaymentMethod() === 'balance')
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="text-center p-3 bg-light rounded">
                                                <small class="text-muted d-block">{{ __('Previous Balance') }}</small>
                                                <h4 class="mb-0">${{ number_format($viewData['previousBalance'], 2) }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="text-center p-3 bg-light rounded">
                                                <small class="text-muted d-block">{{ __('Amount Paid') }}</small>
                                                <h4 class="mb-0 text-danger">-${{ number_format($viewData['order']->getTotal(), 2) }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="text-center p-3 bg-success text-white rounded">
                                                <small class="d-block opacity-75">{{ __('Remaining Balance') }}</small>
                                                <h4 class="mb-0">${{ number_format($viewData['newBalance'], 2) }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($viewData['order']->getInvoicePath())
                                    <div class="text-center p-4 bg-light rounded">
                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        <h5>{{ __('Your Invoice is Ready') }}</h5>
                                        <a href="{{ asset('storage/' . $viewData['order']->getInvoicePath()) }}"
                                            class="btn btn-primary-custom"
                                            download="invoice_{{ $viewData['order']->getId() }}.pdf"
                                            target="_blank">
                                            <i class="fas fa-download me-2"></i>{{ __('Download Invoice (PDF)') }}
                                        </a>
                                    </div>
                                @endif
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i>{{ __('Your payment has been processed successfully.') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Invoice Bill Details -->
                        <div class="card mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>{{ __('Bill Generated') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning mb-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ __('This order is pending payment. Please download your bill and proceed with payment using your preferred method.') }}
                                </div>

                                @if($viewData['order']->getInvoicePath())
                                    <div class="text-center p-4 bg-light rounded">
                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        <h5>{{ __('Your Bill is Ready') }}</h5>
                                        <p class="text-muted">{{ __('Download your bill and complete the payment at your convenience.') }}</p>
                                        <a href="{{ asset('storage/' . $viewData['order']->getInvoicePath()) }}"
                                            class="btn btn-danger btn-lg"
                                            download="bill_{{ $viewData['order']->getId() }}.pdf"
                                            target="_blank">
                                            <i class="fas fa-download me-2"></i>{{ __('Download Bill (PDF)') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

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
