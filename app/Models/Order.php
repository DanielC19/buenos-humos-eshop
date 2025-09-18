<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrderStatus;
use app\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Author: Daniel Arango
 *
 * @property int $id
 * @property OrderStatus $status
 * @property int $subtotal
 * @property int $tax
 * @property int $shipping
 * @property int $total
 * @property string $paymentId
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property orederedProducts[] $orderedProducts
 */
class Order extends Model
{
    protected $fillable = [
        'status',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'paymentId',
        'user',
    ];

    public static function rules(): array
    {
        return [
            'status' => ['required', 'string', 'max:100'],
            'subtotal' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'shipping' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'paymentId' => ['required', 'string', 'max:255'],
            'user' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    *    public function orderedProducts()
    *    {
    *         return $this->hasMany(OrderedProduct::class);
    *    }
    */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function getSubtotal(): int
    {
        return $this->attributes['subtotal'];
    }

    public function getTax(): int
    {
        return $this->attributes['tax'];
    }

    public function getShipping(): int
    {
        return $this->attributes['shipping'];
    }

    public function getTotal(): int
    {
        return $this->attributes['subtotal'] + $this->attributes['tax'] + $this->attributes['shipping'];
    }

    public function getPaymentId(): string
    {
        return $this->attributes['paymentId'];
    }

    public function getUserId(): int
    {
        return $this->attributes['userId'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function setSubtotal(int $subtotal): void
    {
        $this->attributes['subtotal'] = $subtotal;
    }

    public function setTax(int $tax): void
    {
        $this->attributes['tax'] = $tax;
    }

    public function setShipping(int $shipping): void
    {
        $this->attributes['shipping'] = $shipping;
    }

    public function setPaymentId(string $paymentId): void
    {
        $this->attributes['paymentId'] = $paymentId;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['userId'] = $userId;
    }

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }
}
