<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Author: Lucas Higuita
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $banner
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Product[] $products
 */
class ProductCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'banner',
    ];

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'banner' => ['nullable', 'string', 'max:255'],
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

    public function getBanner(): ?string
    {
        return $this->attributes['banner'] ?? null;
    }

    public function setBanner(?string $banner): void
    {
        $this->attributes['banner'] = $banner;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->attributes['created_at'] ? Carbon::parse($this->attributes['created_at']) : null;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->attributes['updated_at'] ? Carbon::parse($this->attributes['updated_at']) : null;
    }

    public function getProducts()
    {
        return Product::where('product_category_id', $this->getId())->get();
    }

    // relationships

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
