<?php

namespace App\Enums;

enum PaymentStatus {

    case paid;
    case unpaid;

    /**
     * get enum status
     */
    public function status(): string
    {
        return match($this)
        {
            PaymentStatus::paid => '1',
            PaymentStatus::unpaid => '0',
        };
    }


    public static function toArray() :array{
        return [
            'Paid'      => (PaymentStatus::paid)->status(),
            'Unpaid'    => (PaymentStatus::unpaid)->status()
        ];
    }
}
