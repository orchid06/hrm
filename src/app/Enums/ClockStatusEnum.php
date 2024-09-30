<?php

namespace App\Enums;

enum ClockStatusEnum: string
{
    case PENDING = '0';
    case APPROVED = '1';
    case DECLINED = '2';

    public function status(): string
    {
        return match($this)
        {
            self::PENDING    => '0',
            self::APPROVED   => '1',
            self::DECLINED   => '2'
        };
    }

    public function statusLabel(): string
    {
        return match($this)
        {
            self::PENDING    => 'Pending',
            self::APPROVED   => 'Approved',
            self::DECLINED   => 'Decline'
        };
    }

    public function badgeClass(): string
    {
        return match($this)
        {
            self::PENDING    => 'warning',
            self::APPROVED   => 'success',
            self::DECLINED   => 'danger'
        };
    }

    public static function toArray(): array
    {
        return [
            'Pending'  => self::PENDING->status(),
            'Approved' => self::APPROVED->status(),
            'Declined' => self::DECLINED->status(),
        ];
    }
}

