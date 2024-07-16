<?php

namespace App\Enums;

enum TwitterConnection: int 
{
    use EnumTrait;

    case MANUAL_TOKEN             = 0;

}