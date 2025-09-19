<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Author: Lucas Higuita
 *
 * @property int           $id
 * @property int           $product_id
 * @property int           $user_id
 * @property int           $score
 * @property string|null   $comment
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property Carbon|null   $deleted_at
 * @property Product       $product
 * @property User          $user
 */
class ProductReview extends Model
{
    use SoftDeletes;

    protected $table = 'product_reviews';

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
            'user_id'    => ['required', 'integer', 'exists:users,id'],
            'score'      => ['required', 'integer', 'min:1', 'max:5'],
            'comment'    => ['nullable', 'string'],
        ];
    }

    public function getProductId(): int 
    {
        return (int)$this->attributes['product_id'];
    }
    public function setProductId(int $productId): void 
    {
        $this->attributes['product_id'] = $productId;
    }

    public function getUserId(): int 
    {
        return (int)$this->attributes['user_id'];
    }
    public function setUserId(int $userId): void 
    {
        $this->attributes['user_id'] = $userId;
    }

    public function getScore(): int 
    {
        return (int)$this->attributes['score'];
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

    protected function casts(): array
    {
        return [
            'product_id' => 'integer',
            'user_id'    => 'integer',
            'score'      => 'integer',
            'deleted_at' => 'datetime',
        ];
    }
}
