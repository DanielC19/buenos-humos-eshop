<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PostCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Author: Daniel Arango
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property PostCategory $category
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category',
    ];

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
        ];
    }

    public function getTitle(): string
    {
        return $this->attributes['title'];
    }

    public function getContent(): string
    {
        return $this->attributes['content'];
    }

    public function getCategory(): PostCategory
    {
        return $this->attributes['category'];
    }

    public function setCategory(PostCategory $category): void
    {
        $this->attributes['category'] = $category;
    }

    public function setTitle(string $title): void
    {
        $this->attributes['title'] = $title;
    }

    public function setContent(string $content): void
    {
        $this->attributes['content'] = $content;
    }

    protected function casts(): array
    {
        return [
            'category' => PostCategory::class,
        ];
    }
}
