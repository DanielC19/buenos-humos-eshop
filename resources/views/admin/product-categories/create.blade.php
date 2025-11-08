@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">{{ __('Create Category') }}</h2>
                    <p class="text-muted mb-0">{{ __('Add a new product category') }}</p>
                </div>
                <a href="{{ route('admin.product-categories.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Categories') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.product-categories.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Category Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Category Name') }} <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="{{ __('Enter category name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="{{ __('Enter category description') }}"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary">
                                {{ __('Reset') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Create Category') }}
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
                        <h6 class="text-primary">{{ __('Category Name') }}</h6>
                        <small class="text-muted">{{ __('Use clear, descriptive names that customers can easily understand. Examples: "Pipes", "Accessories", "Papers"') }}</small>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Description') }}</h6>
                        <small class="text-muted">{{ __('Provide a detailed description of what products belong in this category. This helps with organization and customer navigation.') }}</small>
                    </div>
                    <div class="mb-0">
                        <h6 class="text-primary">{{ __('Best Practices') }}</h6>
                        <small class="text-muted">{{ __('Keep category names short but descriptive. Avoid special characters and use consistent naming conventions.') }}</small>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('Example Categories') }}</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <span class="badge bg-light text-dark me-2">{{ __('Pipes') }}</span>
                            <small class="text-muted">{{ __('Glass pipes, water pipes, etc.') }}</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-light text-dark me-2">{{ __('Papers') }}</span>
                            <small class="text-muted">{{ __('Rolling papers and wraps') }}</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-light text-dark me-2">{{ __('Accessories') }}</span>
                            <small class="text-muted">{{ __('Grinders, lighters, storage') }}</small>
                        </li>
                        <li class="mb-0">
                            <span class="badge bg-light text-dark me-2">{{ __('Vaporizers') }}</span>
                            <small class="text-muted">{{ __('Electronic vaping devices') }}</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
