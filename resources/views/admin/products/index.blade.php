@extends('layouts.admin')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ __('Products Management') }}</h2>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.products.index') }}" method="GET">
                <div class="input-group input-group-sm">
                    <input type="text"
                        class="form-control"
                        name="search"
                        placeholder="{{ __('Search products...') }}"
                        value="{{ $viewData['search'] ?? '' }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(isset($viewData['search']) && $viewData['search'])
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger" title="{{ __('Clear search') }}">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i>{{ __('Add Product') }}
            </a>
        </div>
    </div>

    @if($viewData['products']->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">{{ __('No products found') }}</h4>
                @if(isset($viewData['search']) && $viewData['search'])
                    <p class="text-muted">{{ __('No products match your search criteria.') }}</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('Show All Products') }}
                    </a>
                @else
                    <p class="text-muted">{{ __('Start by creating your first product.') }}</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>{{ __('Create Product') }}
                    </a>
                @endif
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">{{ __('Products List') }}</h5>
                <small class="text-muted">
                    {{ $viewData['products']->count() }}
                    @if(isset($viewData['search']) && $viewData['search'])
                        {{ __('results found') }}
                    @else
                        {{ __('products total') }}
                    @endif
                </small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('SKU') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Stock') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th width="120">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($viewData['products'] as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                @if($product->getImage())
                                                    <img src="{{ asset('storage/' . $product->getImage()) }}"
                                                        alt="{{ $product->getName() }}"
                                                        class="admin-product-image rounded">
                                                @else
                                                    <div class="admin-product-image bg-light rounded d-flex align-items-center justify-content-center"
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $product->getName() }}</h6>
                                                @if($product->getBrand())
                                                    <small class="text-muted">{{ $product->getBrand() }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <code class="bg-light px-2 py-1 rounded">{{ $product->getSku() }}</code>
                                    </td>
                                    <td>
                                        @if($product->getProductCategory())
                                            <span class="badge bg-secondary">{{ $product->getProductCategory()->getName() }}</span>
                                        @else
                                            <span class="text-muted">{{ __('No category') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>${{ number_format($product->getPrice() / 100, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->getStock() > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->getStock() }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->getStock() <= 0)
                                            <span class="badge bg-danger">{{ __('Out of Stock') }}</span>
                                        @elseif($product->getStock() <= 5)
                                            <span class="badge bg-warning">{{ __('Low Stock') }}</span>
                                        @else
                                            <span class="badge bg-success">{{ __('In Stock') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group gap-1">
                                            <span>
                                                <a href="{{ route('admin.products.edit', $product->getId()) }}" class="btn btn-outline-primary" title="{{ __('Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </span>
                                            <form action="{{ route('admin.products.destroy', $product->getId()) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-outline-danger"
                                                        title="{{ __('Delete') }}"
                                                        onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
