<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Author: Lucas Higuita
 *
 * @property int                 $id
 * @property string              $name
 * @property string|null         $description
 * @property string|null         $banner
 * @property Carbon|null         $created_at
 * @property Carbon|null         $updated_at
 * @property Carbon|null         $deleted_at
 * @property Product[]           $Products
 */

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'banner',
    ];

    public static function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'banner'      => ['nullable', 'string', 'max:255'],
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

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
}
