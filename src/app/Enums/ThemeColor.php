<?php

namespace App\Enums;

enum ThemeColor: string
{
    use EnumTrait;

    case PRIMARY_COLOR            = "#10a37f";
    case SECONDARY_COLOR          = "#c2fa6b";
    case TEXT_PRIMARY             = "#24282c";
    case TEXT_SECONDARY           = "#545454";
    case BTN_TEXT_PRIMARY         = "#ffffff";
    case BTN_TEXT_SECONDARY       = "#6a7b65";


}