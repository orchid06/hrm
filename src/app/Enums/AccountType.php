<?php

namespace App\Enums;

enum AccountType: int 
{
    use EnumTrait;

    case PROFILE      = 0;
    case PAGE         = 1;
    case GROUP        = 2;



}