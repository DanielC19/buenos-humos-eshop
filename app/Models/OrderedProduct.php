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
 * @property int $order_id
 * @property int $product_id
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

    public function getProductId(): int
    {
        return $this->attributes['product_id'];
    }

    public function getOrderId(): int
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

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->attributes['order_id'] = $orderId;
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
