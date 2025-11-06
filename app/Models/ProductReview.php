<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Author: Lucas Higuita
 *
 * @property int $id
 * @property int $score
 * @property string|null $comment
 * @property int $product_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Product $product
 * @property User $user
 */
class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'score',
        'comment',
    ];

    public static function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'score' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ];
    }

    // setters & getters

    public function getScore(): int
    {
        return $this->attributes['score'];
    }

    public function setScore(int $score): void
    {
        $this->attributes['score'] = $score;
    }

    public function getComment(): ?string
    {
        return $this->attributes['comment'] ?? null;
    }

    public function setComment(?string $comment): void
    {
        $this->attributes['comment'] = $comment;
    }

    public function getProductId(): int
    {
        return $this->attributes['product_id'];
    }

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product()->associate($product);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user()->associate($user);
    }

    // relationships

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
