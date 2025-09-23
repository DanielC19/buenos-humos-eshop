@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">{{ __('Edit Category') }}</h2>
                    <p class="text-muted mb-0">{{ __('Modify category information') }}</p>
                </div>
                <a href="{{ route('admin.product-category.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Categories') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.product-category.update', $viewData['category']->getId()) }}" method="POST">
                @csrf
                @method('PUT')
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
                                   value="{{ old('name', $viewData['category']->getName()) }}"
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
                                      required>{{ old('description', $viewData['category']->getDescription()) }}</textarea>
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
                                <i class="fas fa-save me-2"></i>{{ __('Update Category') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('Category Details') }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Category ID') }}</h6>
                        <span class="badge bg-light text-dark">{{ $viewData['category']->getId() }}</span>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Current Name') }}</h6>
                        <p class="mb-0">{{ $viewData['category']->getName() }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Current Description') }}</h6>
                        <p class="mb-0 text-muted">{{ $viewData['category']->getDescription() }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">{{ __('Created') }}</h6>
                        <small class="text-muted">
                            @if($viewData['category']->getCreatedAt())
                                {{ $viewData['category']->getCreatedAt()->format('M d, Y \a\t H:i') }}
                            @else
                                {{ __('N/A') }}
                            @endif
                        </small>
                    </div>
                    <div class="mb-0">
                        <h6 class="text-primary">{{ __('Last Updated') }}</h6>
                        <small class="text-muted">
                            @if($viewData['category']->getUpdatedAt())
                                {{ $viewData['category']->getUpdatedAt()->format('M d, Y \a\t H:i') }}
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
                        <h6 class="text-primary">{{ __('Category Name') }}</h6>
                        <small class="text-muted">{{ __('Use clear, descriptive names that customers can easily understand.') }}</small>
                    </div>
                    <div class="mb-0">
                        <h6 class="text-primary">{{ __('Description') }}</h6>
                        <small class="text-muted">{{ __('Provide a detailed description of what products belong in this category.') }}</small>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">{{ __('Danger Zone') }}</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">{{ __('Once you delete a category, there is no going back. Please be certain.') }}</p>
                    <form action="{{ route('admin.product-category.destroy', $viewData['category']->getId()) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger btn-sm w-100"
                                onclick="return confirm('{{ __('Are you sure you want to delete this category? This action cannot be undone.') }}')">
                            <i class="fas fa-trash me-2"></i>{{ __('Delete Category') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
