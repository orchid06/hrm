<?php
  
namespace App\Enums;
 
enum TicketStatus :int {

    use EnumTrait;
    
    case PENDING    = 2;
    case OPEN       = 1;
    case PROCESSING = 3;
    case SOLVED     = 4;
    case HOLD       = 5;
    case CLOSED     = 6;

}