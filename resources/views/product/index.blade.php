@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ __('Products Management') }}</h2>
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>{{ __('Add Product') }}
        </a>
    </div>

    @if($viewData['products']->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">{{ __('No products found') }}</h4>
                <p class="text-muted">{{ __('Start by creating your first product.') }}</p>
                <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('Create Product') }}
                </a>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">{{ __('Products List') }}</h5>
                        <small class="text-muted">{{ $viewData['products']->count() }} {{ __('products total') }}</small>
                    </div>
                    <div class="col-auto">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" class="form-control" placeholder="{{ __('Search products...') }}" id="searchInput">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
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
                                                         class="rounded"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                         style="width: 50px; height: 50px;">
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
                                        @if($product->productCategory)
                                            <span class="badge bg-secondary">{{ $product->productCategory->name }}</span>
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
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-info" title="{{ __('View') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" title="{{ __('Delete') }}"
                                                    onclick="confirmDelete({{ $product->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
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

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');

    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

function confirmDelete(productId) {
    if (confirm('{{ __("Are you sure you want to delete this product?") }}')) {
        // Add delete functionality here
        console.log('Delete product:', productId);
    }
}
</script>
@endsection
