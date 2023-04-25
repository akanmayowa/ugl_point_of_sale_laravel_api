<?php

namespace App\Enums;

enum DebtorStatusEnums : string
{
    case Close = 'closed';
    case Open = 'open';
}
