<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property int $product_category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property ProductCategory $productCategory
 * @property OrderedProduct[] $orderedProducts
 * @property ProductReview[] $productReviews
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'sku',
        'brand',
        'image',
        'stock',
    ];

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku'],
            'brand' => ['nullable', 'string', 'max:150'],
            'image' => ['nullable', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function getSku(): string
    {
        return $this->attributes['sku'];
    }

    public function getBrand(): string
    {
        return $this->attributes['brand'];
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'] ?? null;
    }

    public function getStock(): int
    {
        return $this->attributes['stock'];
    }

    public function getCategoryId(): int
    {
        return $this->attributes['category_id'];
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

    public function setProductCategoryId(int $categoryId): void
    {
        $this->attributes['product_category_id'] = $categoryId;
    }

    public function checkStock(int $quantity = 1): bool
    {
        return $this->getStock() >= $quantity;
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }
}
