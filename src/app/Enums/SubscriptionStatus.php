<?php

namespace App\Enums;

enum SubscriptionStatus: int
{
    use EnumTrait;

    case Running   = 1;
    case Expired   = 3;
    case Inactive  = 2;

}