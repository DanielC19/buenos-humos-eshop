<?php

declare(strict_types=1);

namespace App\Models;

use app\Models\Order;
use app\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Author: Lucas Higuita
 *
 * @property int $id
 * @property int $amount
 * @property int $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Order $order
 * @property Product $product
 */
class OrderedProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'amount',
        'price',
        'order_id',
        'product_id',
    ];

    public static function rules(): array
    {
        return [
            'amount' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
        ];
    }

    public function getAmount(): int
    {
        return $this->attributes['amount'];
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function getProduct_id(): int
    {
        return $this->attributes['product_id'];
    }

    public function getOrder_id(): int
    {
        return $this->attributes['order_id'];
    }

    public function setAmount(int $amount): void
    {
        $this->attributes['amount'] = $amount;
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function setProduct_id(int $product_id): void
    {
        $this->attributes['product_id'] = $product_id;
    }

    public function setOrder_id(int $order_id): void
    {
        $this->attributes['order_id'] = $order_id;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
}
