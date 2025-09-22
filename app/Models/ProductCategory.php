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
 * @property Carbon $created_at
 * @property Carbon $updated_at
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

    public function getProducts(): array
    {
        return $this->attributes['products'] ?? [];
    }

    public function setProducts(array $products): void
    {
        $this->attributes['products'] = $products;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
