<?php

namespace App\Enums;

enum PayslipCycle: int
{
    use EnumTrait;

    case WEEKLY    = 1;
    case BI_WEEKLY = 2;
    case MONTHLY   = 3;

}
