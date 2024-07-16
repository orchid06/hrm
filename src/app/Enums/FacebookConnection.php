<?php

namespace App\Enums;

enum FacebookConnection: int 
{
    use EnumTrait;

    case MANUAL_TOKEN             = 0;
    case FACEBOOK_OAUTH           = 1;

}