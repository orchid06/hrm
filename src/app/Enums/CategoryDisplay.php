<?php

namespace App\Enums;

enum CategoryDisplay: int 
{
    use EnumTrait;

    case Article      = 0;
    case Template     = 1;
    case Both         = 2;

}