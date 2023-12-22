<?php

namespace App\Enums;

enum AccountType: int 
{
    use EnumTrait;

    case Profile      = 0;
    case Page         = 1;
    case Group        = 2;



}