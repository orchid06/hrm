<?php

namespace App\Enums;

enum SalaryTypeEnum {

    case ALLOWANCE;
    case DEDUCTION;

    /**
     * get enum status
     */
    public function status(): string
    {
        return match($this)
        {
            SalaryTypeEnum::ALLOWANCE => '1',
            SalaryTypeEnum::DEDUCTION => '0',
        };
    }


    public static function toArray() :array{
        return [
            'Allowance' => (SalaryTypeEnum::ALLOWANCE)->status(),
            'Deduction' => (SalaryTypeEnum::DEDUCTION)->status()
        ];
    }

}
