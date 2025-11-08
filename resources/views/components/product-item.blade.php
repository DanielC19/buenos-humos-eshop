@props(['product'])

<div class="col-lg-3 col-md-6 mb-4">
    <div class="product-card">
        <a href="{{ route('products.show', $product->getId()) }}">
            <div class="product-image">
                @if($product->getImage())
                    <img src="{{ $product->getImage() }}" alt="{{ $product->getName() }}" class="img-fluid">
                @else
                    <i class="fas fa-leaf"></i>
                @endif
            </div>
            <div class="p-3">
                <h6>{{ $product->getName() }}</h6>
                <p class="text-muted small">{{ $product->getDescription() }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="price">${{ number_format($product->getPrice(), 2) }}</span>
                    @if ($product->getStock() !== 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="productId" value="{{ $product->getId() }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm btn-primary-custom">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </a>
    </div>
</div>
