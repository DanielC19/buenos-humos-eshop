@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center my-5">
            <h1 class="display-4">404</h1>
            <p class="lead">{{ __('Page Not Found') }}</p>
            <a href="{{ route('home.index') }}" class="btn btn-primary-custom">
                <i class="fas fa-home me-2"></i>{{ __('Go to Homepage') }}
            </a>
        </div>
    </div>
@endsection