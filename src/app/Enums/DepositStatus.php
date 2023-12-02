<?php
  
namespace App\Enums;
 
enum DepositStatus :int {

    use EnumTrait;

    case INITIATE        = -1;
    case PAID            =  1;
    case CANCEL          =  2;
    case PENDING         =  3;
    case FAILED          =  4;
    case REJECTED        =  5;
}