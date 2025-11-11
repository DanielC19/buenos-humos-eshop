<?php

declare(strict_types=1);

namespace App\Services;

class CartService
{
    public static int $TAX_PERCENTAGE = 19;

    public static int $SHIPPING_COST = 500;

    private array $cartProducts;

    private array $products;

    public function __construct(array $cartProducts, array $products)
    {
        $this->cartProducts = $cartProducts;
        $this->products = $products;
    }

    public function calculateSubtotal(): int
    {
        $subtotal = 0;

        foreach ($this->products as $product) {
            $productId = $product->getId();
            if (isset($this->cartProducts[$productId])) {
                $quantity = $this->cartProducts[$productId];
                $productPrice = intval($product->getPrice() * $quantity);
                $subtotal += $productPrice;
            }
        }

        return $subtotal;
    }

    public function calculateTax(): int
    {
        $subtotal = $this->calculateSubtotal();

        return intval($subtotal * (self::$TAX_PERCENTAGE / 100));
    }

    public function calculateTotal(): int
    {
        $subtotal = $this->calculateSubtotal();
        $tax = $this->calculateTax();

        return $subtotal + $tax + self::$SHIPPING_COST;
    }

    public function checkStock(): bool
    {
        foreach ($this->products as $product) {
            $productId = $product->getId();
            if (isset($this->cartProducts[$productId])) {
                $quantity = $this->cartProducts[$productId];
                if ($product->getStock() < $quantity) {
                    return false;
                }
            }
        }

        return true;
    }
}
