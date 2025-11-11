<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @property string|null $invoice_path
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property OrderedProduct[] $orderedProducts
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
        'payment_method',
        'invoice_path',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    public static function rules(): array
    {
        return [
            'status' => ['required', 'string', 'max:100'],
            'subtotal' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'shipping' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'payment_id' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:100'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    // setters & getters

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function getSubtotal(): int
    {
        return $this->attributes['subtotal'];
    }

    public function setSubtotal(int $subtotal): void
    {
        $this->attributes['subtotal'] = $subtotal;
    }

    public function getTax(): int
    {
        return $this->attributes['tax'];
    }

    public function setTax(int $tax): void
    {
        $this->attributes['tax'] = $tax;
    }

    public function getShipping(): int
    {
        return $this->attributes['shipping'];
    }

    public function setShipping(int $shipping): void
    {
        $this->attributes['shipping'] = $shipping;
    }

    public function getTotal(): int
    {
        return $this->attributes['total'];
    }

    public function setTotal(int $total): void
    {
        $this->attributes['total'] = $total;
    }

    public function getPaymentId(): string
    {
        return $this->attributes['payment_id'];
    }

    public function setPaymentId(string $paymentId): void
    {
        $this->attributes['paymentId'] = $paymentId;
    }

    public function getPaymentMethod(): string
    {
        return $this->attributes['payment_method'];
    }

    public function setPaymentMethod(string $paymentMethod): void
    {
        $this->attributes['payment_method'] = $paymentMethod;
    }

    public function getInvoicePath(): ?string
    {
        return $this->attributes['invoice_path'] ?? null;
    }

    public function setInvoicePath(?string $invoicePath): void
    {
        $this->attributes['invoice_path'] = $invoicePath;
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['userId'] = $userId;
    }

    public function getUser(): User
    {
        return User::find($this->getUserId());
    }

    public function setUser(User $user): void
    {
        $this->user()->associate($user);
    }

    public function getOrderedProducts(): Collection
    {
        return OrderedProduct::where('order_id', $this->getId())->get();
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->attributes['created_at'] ? Carbon::parse($this->attributes['created_at']) : null;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->attributes['updated_at'] ? Carbon::parse($this->attributes['updated_at']) : null;
    }

    // relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderedProducts(): HasMany
    {
        return $this->hasMany(OrderedProduct::class);
    }
}
