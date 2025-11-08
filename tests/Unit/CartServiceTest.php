<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Product;
use App\Services\CartService;
use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    private function createMockProduct(int $id, int $price, int $stock): Product
    {
        $product = $this->createMock(Product::class);

        $product->method('getId')->willReturn($id);
        $product->method('getPrice')->willReturn($price);
        $product->method('getStock')->willReturn($stock);

        return $product;
    }

    public function test_calculates_subtotal_correctly_with_single_product(): void
    {
        // Given: A cart with 2 units of a product priced at 1000
        $product = $this->createMockProduct(1, 1000, 10);
        $cartProducts = [1 => 2];

        $cartService = new CartService($cartProducts, [$product]);

        // When: Calculate subtotal
        $subtotal = $cartService->calculateSubtotal();

        // Then: Subtotal should be 2000 (1000 × 2)
        $this->assertEquals(2000.0, $subtotal);
    }

    public function test_calculates_subtotal_correctly_with_multiple_products(): void
    {
        // Given: A cart with multiple products
        $product1 = $this->createMockProduct(1, 1000, 10);
        $product2 = $this->createMockProduct(2, 500, 5);
        $product3 = $this->createMockProduct(3, 250, 20);

        $cartProducts = [
            1 => 2,  // 2 × 1000 = 2000
            2 => 1,  // 1 × 500 = 500
            3 => 4,  // 4 × 250 = 1000
        ];

        $cartService = new CartService($cartProducts, [$product1, $product2, $product3]);

        // When: Calculate subtotal
        $subtotal = $cartService->calculateSubtotal();

        // Then: Subtotal should be 3500
        $this->assertEquals(3500.0, $subtotal);
    }

    public function test_calculates_subtotal_as_zero_for_empty_cart(): void
    {
        // Given: An empty cart
        $product = $this->createMockProduct(1, 1000, 10);
        $cartProducts = [];

        $cartService = new CartService($cartProducts, [$product]);

        // When: Calculate subtotal
        $subtotal = $cartService->calculateSubtotal();

        // Then: Subtotal should be 0
        $this->assertEquals(0.0, $subtotal);
    }

    public function test_calculates_tax_as_19_percent_of_subtotal(): void
    {
        // Given: A cart with subtotal of 1000
        $product = $this->createMockProduct(1, 1000, 10);
        $cartProducts = [1 => 1];

        $cartService = new CartService($cartProducts, [$product]);

        // When: Calculate tax
        $tax = $cartService->calculateTax();

        // Then: Tax should be 190 (19% of 1000)
        $this->assertEquals(190.0, $tax);
    }

    public function test_calculates_total_with_shipping_cost(): void
    {
        // Given: A cart with subtotal of 1000
        $product = $this->createMockProduct(1, 1000, 10);
        $cartProducts = [1 => 1];

        $cartService = new CartService($cartProducts, [$product]);

        // When: Calculate total
        $total = $cartService->calculateTotal();

        // Then: Total should be subtotal (1000) + tax (190) + shipping (5) = 1195
        $this->assertEquals(1195.0, $total);
    }

    public function test_calculates_total_correctly_with_multiple_products(): void
    {
        // Given: A cart with multiple products
        $product1 = $this->createMockProduct(1, 1000, 10);
        $product2 = $this->createMockProduct(2, 500, 5);

        $cartProducts = [
            1 => 2,  // 2 × 1000 = 2000
            2 => 1,  // 1 × 500 = 500
        ];

        $cartService = new CartService($cartProducts, [$product1, $product2]);

        // When: Calculate total
        $total = $cartService->calculateTotal();

        // Then: Total should be subtotal (2500) + tax (475) + shipping (5) = 2980
        $this->assertEquals(2980.0, $total);
    }

    public function test_check_stock_returns_true_when_stock_is_sufficient(): void
    {
        // Given: Products with sufficient stock
        $product1 = $this->createMockProduct(1, 1000, 10);
        $product2 = $this->createMockProduct(2, 500, 5);

        $cartProducts = [
            1 => 5,  // Requesting 5, have 10
            2 => 3,  // Requesting 3, have 5
        ];

        $cartService = new CartService($cartProducts, [$product1, $product2]);

        // When: Check stock
        $hasStock = $cartService->checkStock();

        // Then: Should return true
        $this->assertTrue($hasStock);
    }

    public function test_check_stock_returns_false_when_stock_is_insufficient(): void
    {
        // Given: Products with insufficient stock
        $product1 = $this->createMockProduct(1, 1000, 10);
        $product2 = $this->createMockProduct(2, 500, 3);

        $cartProducts = [
            1 => 5,  // Requesting 5, have 10 - OK
            2 => 5,  // Requesting 5, have 3 - NOT OK
        ];

        $cartService = new CartService($cartProducts, [$product1, $product2]);

        // When: Check stock
        $hasStock = $cartService->checkStock();

        // Then: Should return false
        $this->assertFalse($hasStock);
    }

    public function test_check_stock_returns_true_for_exact_stock_match(): void
    {
        // Given: Product with exact stock amount requested
        $product = $this->createMockProduct(1, 1000, 5);
        $cartProducts = [1 => 5];

        $cartService = new CartService($cartProducts, [$product]);

        // When: Check stock
        $hasStock = $cartService->checkStock();

        // Then: Should return true
        $this->assertTrue($hasStock);
    }

    public function test_ignores_products_not_in_cart(): void
    {
        // Given: Products where only one is in the cart
        $product1 = $this->createMockProduct(1, 1000, 10);
        $product2 = $this->createMockProduct(2, 500, 5);

        $cartProducts = [1 => 2];  // Only product 1 in cart

        $cartService = new CartService($cartProducts, [$product1, $product2]);

        // When: Calculate subtotal
        $subtotal = $cartService->calculateSubtotal();

        // Then: Should only count product 1
        $this->assertEquals(2000.0, $subtotal);
    }
}
