<?php
  
namespace App\Enums;
 
enum WithdrawStatus :int {

    use EnumTrait;

    case PENDING        = 3;
    case APPROVED       = 1;
    case REJECTED       = 2;


}