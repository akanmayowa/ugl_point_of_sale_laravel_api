<?php

namespace App\Enums;

enum OrderStatusEnums : string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Rejected =  'rejected';
}
