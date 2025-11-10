<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\CurrencyExchangeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

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
        'product_category_id',
    ];

    public static function rules(?int $productId = null): array
    {
        if ($productId === null) {
            $productId = '';
        } else {
            $productId = ','.$productId;
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku'.$productId],
            'brand' => ['nullable', 'string', 'max:150'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:2048'],
            'stock' => ['required', 'integer', 'min:0'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
        ];
    }

    // setters & getters

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getSku(): string
    {
        return $this->attributes['sku'];
    }

    public function setSku(string $sku): void
    {
        $this->attributes['sku'] = $sku;
    }

    public function getBrand(): string
    {
        return $this->attributes['brand'];
    }

    public function setBrand(string $brand): void
    {
        $this->attributes['brand'] = $brand;
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'] ?? null;
    }

    public function setImage(?string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function getStock(): int
    {
        return $this->attributes['stock'];
    }

    public function setStock(int $stock): void
    {
        $this->attributes['stock'] = $stock;
    }

    public function getCategoryId(): int
    {
        return $this->attributes['product_category_id'];
    }

    public function setProductCategoryId(int $categoryId): void
    {
        $this->attributes['product_category_id'] = $categoryId;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->attributes['created_at'] ? Carbon::parse($this->attributes['created_at']) : null;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->attributes['updated_at'] ? Carbon::parse($this->attributes['updated_at']) : null;
    }

    public function getProductCategory(): ProductCategory
    {
        return ProductCategory::find($this->getCategoryId());
    }

    public function setProductCategory(ProductCategory $productCategory): void
    {
        $this->productCategory()->associate($productCategory);
    }

    public function getProductReviews(): Collection
    {
        return ProductReview::where('product_id', $this->getId())->get();
    }

    public function getOrderedProducts(): Collection
    {
        return OrderedProduct::where('product_id', $this->getId())->get();
    }

    // utils

    public static function searchAndOrder(?string $search = null, ?string $mostSold = null, ?int $pagination = 20): LengthAwarePaginator
    {
        $query = self::query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('brand', 'like', "%$search%");
        }

        if ($mostSold) {
            $query->withCount('orderedProducts')
                ->orderByDesc('ordered_products_count');
        } else {
            $query->orderBy('name');
        }

        return $query->paginate($pagination);
    }

    public function checkStock(int $quantity = 1): bool
    {
        return $this->getStock() >= $quantity;
    }

    public function getDisplayPrice(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'es') {
            // Convert USD to COP for Spanish locale
            $exchangeService = app(CurrencyExchangeService::class);
            $usdToCopRate = $exchangeService->getUsdToCopRate();

            $displayNumber = number_format(($this->getPrice() * $usdToCopRate) / 100, 0, '', '.');

            return "COP $$displayNumber";
        }

        // Return USD price
        $displayNumber = number_format($this->getPrice() / 100, 2, '.', ',');

        return "USD $$displayNumber";
    }

    // relationships

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function orderedProducts(): HasMany
    {
        return $this->hasMany(OrderedProduct::class);
    }
}
