@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-2">{{ __('Dashboard Overview') }}</h2>
        <p class="text-muted">{{ __('Welcome back') }}, {{ Auth::user()->getName() }}!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="admin-stat-card">
                <div class="stat-icon icon-primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value">{{ $viewData['totalProducts'] }}</div>
                <div class="stat-label">{{ __('Total Products') }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="admin-stat-card">
                <div class="stat-icon icon-success">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">{{ $viewData['totalOrders'] }}</div>
                <div class="stat-label">{{ __('Total Orders') }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="admin-stat-card">
                <div class="stat-icon icon-info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $viewData['totalCustomers'] }}</div>
                <div class="stat-label">{{ __('Total Customers') }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="admin-stat-card">
                <div class="stat-icon icon-warning">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-value">${{ number_format($viewData['totalRevenue'] / 100, 2) }}</div>
                <div class="stat-label">{{ __('Total Revenue') }}</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
        <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Quick Actions') }}</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>{{ __('Add New Product') }}
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.product-categories.create') }}" class="btn btn-success w-100">
                        <i class="fas fa-folder-plus me-2"></i>{{ __('Add New Category') }}
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-box me-2"></i>{{ __('Manage Products') }}
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.product-categories.index') }}" class="btn btn-outline-success w-100">
                        <i class="fas fa-folder me-2"></i>{{ __('Manage Categories') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
