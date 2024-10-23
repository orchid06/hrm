<?php

namespace App\Enums;

enum PaymentStatus {

    case PAID;
    case UNPAID;

    /**
     * get enum status
     */
    public function status(): string
    {
        return match($this)
        {
            PaymentStatus::PAID => '1',
            PaymentStatus::UNPAID => '0',
        };
    }


    public static function toArray() :array{
        return [
            'Paid'      => (PaymentStatus::PAID)->status(),
            'Unpaid'    => (PaymentStatus::UNPAID)->status()
        ];
    }
}
