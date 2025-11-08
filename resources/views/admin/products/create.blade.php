@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">{{ __('Create Product') }}</h2>
                    <p class="text-muted mb-0">{{ __('Add a new product to the inventory') }}</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Products') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                                       value="{{ old('name') }}"
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
                                       value="{{ old('sku') }}"
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
                                      required>{{ old('description') }}</textarea>
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
                                           value="{{ old('price') }}"
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
                                       value="{{ old('stock') }}"
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
                                       value="{{ old('brand') }}">
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
                                                {{ old('product_category_id') == $category->getId() ? 'selected' : '' }}>
                                            {{ $category->getName() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">{{ __('Product Image') }}</label>
                                <input type="file"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                                <div class="form-text">{{ __('Accepted formats: JPEG, PNG, GIF, WebP. Max size: 2MB') }}</div>
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
                                <i class="fas fa-save me-2"></i>{{ __('Create Product') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
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
                        <small class="text-muted">{{ __('Use a unique identifier. Example: PRD-001, SMOKE-PIPE-01') }}</small>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Image Requirements') }}</h6>
                        <small class="text-muted">{{ __('Upload high-quality images. Square format (1:1) works best.') }}</small>
                    </div>
                    <div class="mb-0">
                        <h6 class="text-primary">{{ __('Stock Management') }}</h6>
                        <small class="text-muted">{{ __('Keep accurate stock levels to prevent overselling.') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
