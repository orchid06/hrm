<?php

namespace App\Enums;

enum LeaveDurationType: string
{
    case FULL_DAY = 'Full day';
    case BEFORE_LUNCH = 'Before Lunch';
    case AFTER_LUNCH = 'After Lunch';
    case RANGE = 'Range';

    public static function toArray(): array
    {
        return [
            self::FULL_DAY->value,
            self::BEFORE_LUNCH->value,
            self::AFTER_LUNCH->value,
            self::RANGE->value,
        ];
    }
}
