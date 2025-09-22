@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ __('Product Categories Management') }}</h2>
        <a href="{{ route('admin.product-category.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>{{ __('Add Category') }}
        </a>
    </div>

    @if($viewData['categories']->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">{{ __('No categories found') }}</h4>
                <p class="text-muted">{{ __('Start by creating your first product category.') }}</p>
                <a href="{{ route('admin.product-category.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('Create Category') }}
                </a>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">{{ __('Categories List') }}</h5>
                        <small class="text-muted">{{ $viewData['categories']->count() }} {{ __('categories total') }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">{{ __('ID') }}</th>
                                <th>{{ __('Category Name') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th style="width: 150px;">{{ __('Created') }}</th>
                                <th width="120">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($viewData['categories'] as $category)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $category->getId() }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $category->getName() }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">
                                            {{ Str::limit($category->getDescription(), 80) }}
                                        </p>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            @if($category->created_at)
                                                {{ $category->created_at->format('M d, Y') }}
                                            @else
                                                {{ __('N/A') }}
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.product-category.edit', $category->getId()) }}"
                                               class="btn btn-outline-primary"
                                               title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.product-category.destroy', $category->getId()) }}"
                                                  method="POST"
                                                  style="display: inline;">
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
