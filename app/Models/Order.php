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
 * @property string $payment_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property OrderedProducts[] $orderedProducts
 */
class Order extends Model
{
    protected $fillable = [
        'status',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'payment_id',
        'user_id',
    ];

    public static function rules(): array
    {
        return [
            'status' => ['required', 'string', 'max:100'],
            'subtotal' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'shipping' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'payment_id' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

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
        return (int) $this->attributes['total'];
    }

    public function getPaymentId(): string
    {
        return $this->attributes['payment_id'];
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
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

    public function setTotal(int $total): void
    {
        $this->attributes['total'] = $total;
    }

    public function setPaymentId(string $paymentId): void
    {
        $this->attributes['payment_id'] = $paymentId;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    protected function orderedProducts()
    {
        return $this->hasMany(OrderedProduct::class);
    }
}
