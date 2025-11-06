@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">{{ __('Admin Dashboard') }}</h1>
        <p>{{ __('Welcome to the admin dashboard!') }}</p>
        <div class="list-group">
            <a href="{{ route('admin.product-categories.index') }}" class="list-group-item list-group-item-action">
                {{ __('Manage Product Categories') }}
            </a>
            <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">
                {{ __('Manage Products') }}
            </a>
        </div>
    </div>
@endsection
