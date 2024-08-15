<?php

namespace App\Enums;

enum SalaryTypeEnum {

    case allowance;
    case deduction;

    /**
     * get enum status
     */
    public function status(): string
    {
        return match($this)
        {
            SalaryTypeEnum::allowance => '1',
            SalaryTypeEnum::deduction => '0',
        };
    }


    public static function toArray() :array{
        return [
            'Allowance' => (SalaryTypeEnum::allowance)->status(),
            'Deduction' => (SalaryTypeEnum::deduction)->status()
        ];
    }

}
