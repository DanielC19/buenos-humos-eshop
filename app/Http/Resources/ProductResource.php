<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Product $resource
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'description' => $this->resource->getDescription(),
            'price' => $this->resource->getPrice(),
            'sku' => $this->resource->getSku(),
            'brand' => $this->resource->getBrand(),
            'stock' => $this->resource->getStock(),
            'image' => config('app.url').'/storage/'.$this->resource->getImage(),
            'url' => config('app.url').'/products/show/'.$this->resource->getId(),
            'category' => [
                'id' => $this->resource->productCategory->getId(),
                'name' => $this->resource->productCategory->getName(),
                'description' => $this->resource->productCategory->getDescription(),
            ],
        ];
    }
}
