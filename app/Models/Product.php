<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Author: Lucas Higuita
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property string $sku
 * @property string|null $brand
 * @property string|null $image
 * @property int $stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property ProductCategory $product_category
 * @property int $category_id
 * @property OrderedProduct[] $orderedProducts
 * @property ProductReview[] $reviews
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'sku',
        'brand',
        'image',
        'stock',
        'product_category',
        'category_id',
        'reviews',
    ];

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku'],
            'brand' => ['required', 'string', 'max:150'],
            'image' => ['nullable', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'product_category' => ['required', 'integer', 'exists:product_categories,id'],
            'category_id' => ['required', 'integer', 'exists:product_categories,id'],
        ];
    }

    public function getName(): string
    {
        return (string) $this->attributes['name'];
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function getPrice(): int
    {
        return (int) $this->attributes['price'];
    }

    public function getSku(): string
    {
        return (string) $this->attributes['sku'];
    }

    public function getBrand(): string
    {
        return (string) $this->attributes['brand'];
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'] ?? null;
    }

    public function getStock(): int
    {
        return (int) $this->attributes['stock'];
    }

    public function getCategoryId(): int
    {
        return (int) $this->attributes['category_id'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function setSku(string $sku): void
    {
        $this->attributes['sku'] = $sku;
    }

    public function setBrand(string $brand): void
    {
        $this->attributes['brand'] = $brand;
    }

    public function setImage(?string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function setStock(int $stock): void
    {
        $this->attributes['stock'] = $stock;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->attributes['category_id'] = $categoryId;
    }

    public function checkStock(int $quantity = 1): bool
    {
        return $this->getStock() >= $quantity;
    }
}
