<?php

declare(strict_types=1);

namespace App\Enums;

enum PostCategory: string
{
    case HEALTH = 'health';
    case LIFESTYLE = 'lifestyle';
    case RECREATION = 'recreation';

    public function label(): string
    {
        return match ($this) {
            self::HEALTH => 'Health',
            self::LIFESTYLE => 'Lifestyle',
            self::RECREATION => 'Recreation',
        };
    }
}
