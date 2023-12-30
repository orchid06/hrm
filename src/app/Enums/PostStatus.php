<?php

namespace App\Enums;

enum PostStatus: int 
{
    use EnumTrait;

    case Pending         = 0;
    case Success         = 1;
    case Failed          = 2;
    case Schedule        = 3;



}