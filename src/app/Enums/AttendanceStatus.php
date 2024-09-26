<?php

namespace App\Enums;

enum AttendanceStatus : string
{
    case HOLIDAY    = '0';
    case DAYOFF     = '1';
    case PRESENT    = '2';
    case HALF_DAY   = '3';
    case LATE       = '4';
    case ABSENT     = '5';
    case ON_LEAVE   = '6';

    public function status(): string
    {
        return match($this)
        {
            self::pending    => '0',
            self::approved   => '1',
            self::declined   => '2'
        };
    }

    public function statusLabel(): string
    {
        return match($this)
        {
            self::pending    => 'Pending',
            self::approved   => 'Approved',
            self::declined   => 'Decline'
        };
    }

    public function badgeClass(): string
    {
        return match($this)
        {
            self::pending    => 'warning',
            self::approved   => 'success',
            self::declined   => 'danger'
        };
    }

    public static function toArray(): array
    {
        return [
            'Pending'  => self::pending->status(),
            'Approved' => self::approved->status(),
            'Declined' => self::declined->status(),
        ];
    }
}
