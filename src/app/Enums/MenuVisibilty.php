<?php

namespace App\Enums;

enum MenuVisibilty: int 
{
    use EnumTrait;

    case Header       = 0;
    case Footer       = 1;
    case Both         = 2;

}