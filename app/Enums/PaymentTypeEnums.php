<?php

namespace App\Enums;

enum PaymentTypeEnums : string
{
    case OnCredit = 'on-credit';
    case CompletePayment = 'complete-payment';
}
