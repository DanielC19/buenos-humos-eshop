@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">{{ __('Edit Product') }}</h2>
                    <p class="text-muted mb-0">{{ __('Modify product information') }}</p>
                </div>
                <a href="{{ route('admin.product.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Products') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.product.update', $viewData['product']->getId()) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Product Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="name" class="form-label">{{ __('Product Name') }} <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $viewData['product']->getName()) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sku" class="form-label">{{ __('SKU') }} <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('sku') is-invalid @enderror"
                                       id="sku"
                                       name="sku"
                                       value="{{ old('sku', $viewData['product']->getSku()) }}"
                                       required>
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      required>{{ old('description', $viewData['product']->getDescription()) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">{{ __('Price') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number"
                                           class="form-control @error('price') is-invalid @enderror"
                                           id="price"
                                           name="price"
                                           value="{{ old('price', number_format($viewData['product']->getPrice() / 100, 2, '.', '')) }}"
                                           step="0.01"
                                           min="0"
                                           required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="stock" class="form-label">{{ __('Stock Quantity') }} <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       id="stock"
                                       name="stock"
                                       value="{{ old('stock', $viewData['product']->getStock()) }}"
                                       min="0"
                                       required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="brand" class="form-label">{{ __('Brand') }}</label>
                                <input type="text"
                                       class="form-control @error('brand') is-invalid @enderror"
                                       id="brand"
                                       name="brand"
                                       value="{{ old('brand', $viewData['product']->getBrand()) }}">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_category_id" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('product_category_id') is-invalid @enderror"
                                        id="product_category_id"
                                        name="product_category_id"
                                        required>
                                    <option value="">{{ __('Select a category') }}</option>
                                    @foreach($viewData['categories'] ?? [] as $category)
                                        <option value="{{ $category->getId() }}"
                                                {{ old('product_category_id', $viewData['product']->getCategoryId()) == $category->getId() ? 'selected' : '' }}>
                                            {{ $category->getName() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">{{ __('Product Image URL') }}</label>
                                <input type="url"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       value="{{ old('image', $viewData['product']->getImage()) }}"
                                       placeholder="https://example.com/image.jpg">
                                <div class="form-text">{{ __('Enter a valid image URL from the internet') }}</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary">
                                {{ __('Reset') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Update Product') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('Product Details') }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Product ID') }}</h6>
                        <span class="badge bg-light text-dark">{{ $viewData['product']->getId() }}</span>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Current Name') }}</h6>
                        <p class="mb-0">{{ $viewData['product']->getName() }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Current SKU') }}</h6>
                        <code class="bg-light px-2 py-1 rounded">{{ $viewData['product']->getSku() }}</code>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Current Price') }}</h6>
                        <span class="text-success fw-bold">${{ number_format($viewData['product']->getPrice() / 100, 2) }}</span>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Current Stock') }}</h6>
                        <span class="badge {{ $viewData['product']->getStock() > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $viewData['product']->getStock() }}
                        </span>
                    </div>
                    @if($viewData['product']->getImage())
                        <div class="mb-3">
                            <h6 class="text-primary">{{ __('Current Image') }}</h6>
                            <img src="{{ $viewData['product']->getImage() }}"
                                 alt="{{ $viewData['product']->getName() }}"
                                 class="img-fluid rounded"
                                 style="max-height: 200px;"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div style="display: none;" class="text-muted small">
                                {{ __('Image failed to load') }}
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">{{ $viewData['product']->getImage() }}</small>
                            </div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Created') }}</h6>
                        <small class="text-muted">
                            @if($viewData['product']->created_at)
                                {{ $viewData['product']->created_at->format('M d, Y \a\t H:i') }}
                            @else
                                {{ __('N/A') }}
                            @endif
                        </small>
                    </div>
                    <div class="mb-0">
                        <h6 class="text-primary">{{ __('Last Updated') }}</h6>
                        <small class="text-muted">
                            @if($viewData['product']->updated_at)
                                {{ $viewData['product']->updated_at->format('M d, Y \a\t H:i') }}
                            @else
                                {{ __('N/A') }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('Guidelines') }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Product Name') }}</h6>
                        <small class="text-muted">{{ __('Use clear, descriptive names that customers can easily search for.') }}</small>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('SKU Format') }}</h6>
                        <small class="text-muted">{{ __('Keep the same format when editing. Example: PRD-001, SMOKE-PIPE-01') }}</small>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Price Input') }}</h6>
                        <small class="text-muted">{{ __('Enter the price in dollars (e.g., enter 20.99 for $20.99). The system will automatically convert to cents for storage.') }}</small>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Price Input') }}</h6>
                        <small class="text-muted">{{ __('Enter the price in dollars (e.g., enter 20.99 for $20.99). The system will automatically convert to cents for storage.') }}</small>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Image Guidelines') }}</h6>
                        <small class="text-muted">{{ __('Use direct image URLs from reliable sources. Make sure the URL ends with .jpg, .png, or .gif and is publicly accessible.') }}</small>
                    </div>
                    <div class="mb-0">
                        <h6 class="text-primary">{{ __('Stock Management') }}</h6>
                        <small class="text-muted">{{ __('Update stock levels carefully to prevent overselling.') }}</small>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">{{ __('Danger Zone') }}</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">{{ __('Once you delete a product, there is no going back. Please be certain.') }}</p>
                    <form action="{{ route('admin.product.destroy', $viewData['product']->getId()) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger btn-sm w-100"
                                onclick="return confirm('{{ __('Are you sure you want to delete this product? This action cannot be undone.') }}')">
                            <i class="fas fa-trash me-2"></i>{{ __('Delete Product') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
