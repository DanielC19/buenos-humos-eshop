@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">{{ __('Products') }}</h1>

        @if($viewData['products']->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">{{ __('No products found.') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($viewData['products'] as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if($product->getImage())
                            <img src="{{ $product->getImage() }}" alt="{{ $product->getName() }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">{{ __('No Image') }}</span>
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2 text-gray-800">{{ $product->getName() }}</h3>

                            @if($product->getBrand())
                                <p class="text-sm text-gray-600 mb-2">{{ $product->getBrand() }}</p>
                            @endif

                            <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ Str::limit($product->getDescription(), 100) }}</p>

                            <div class="flex justify-between items-center mb-3">
                                <span class="text-2xl font-bold text-green-600">${{ number_format($product->getPrice() / 100, 2) }}</span>
                                <span class="text-sm text-gray-500">SKU: {{ $product->getSku() }}</span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                @if($product->productCategory)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $product->productCategory->name }}</span>
                                @endif

                                <span class="text-sm {{ $product->getStock() > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    @if($product->getStock() > 0)
                                        {{ $product->getStock() }} in stock
                                    @else
                                        Out of stock
                                    @endif
                                </span>
                            </div>

                            <button class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors duration-300 {{ $product->getStock() <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $product->getStock() <= 0 ? 'disabled' : '' }}>
                                @if($product->getStock() > 0)
                                    {{ __('Add to Cart') }}
                                @else
                                    {{ __('Out of Stock') }}
                                @endif
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
