<?php

namespace App\Enums;

enum NewsSource: string
{
    case GUARDIAN = 'guardian';
    case NEWSAPI = 'newsapi';
    case NEW_YORK_TIMES = 'new_york_times';

    /**
     * Get all enum values as an array.
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
