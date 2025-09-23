<?php

declare(strict_types=1);

namespace App\Services;

class CartService
{
    public static int $TAX_PERCENTAGE = 19;

    public static int $SHIPPING_COST = 5;

    private array $cartProducts;

    private array $products;

    public function __construct(array $cartProducts, array $products)
    {
        $this->cartProducts = $cartProducts;
        $this->products = $products;
    }

    public function calculateSubtotal(): float
    {
        $subtotal = 0.0;

        foreach ($this->products as $product) {
            $productId = $product->getId();
            if (isset($this->cartProducts[$productId])) {
                $quantity = $this->cartProducts[$productId];
                $productPrice = $product->getPrice() * $quantity;
                $subtotal += $productPrice;
            }
        }

        return $subtotal;
    }

    public function calculateTax(): float
    {
        $subtotal = $this->calculateSubtotal();

        return $subtotal * (self::$TAX_PERCENTAGE / 100);
    }

    public function calculateTotal(): float
    {
        $subtotal = $this->calculateSubtotal();
        $tax = $this->calculateTax();

        return $subtotal + $tax + self::$SHIPPING_COST;
    }
}
