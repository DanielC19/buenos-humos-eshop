<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string
{
    case VALIDATING = 'validating';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::VALIDATING => 'Validating',
            self::CONFIRMED => 'Confirmed',
            self::CANCELLED => 'Cancelled',
        };
    }
}
