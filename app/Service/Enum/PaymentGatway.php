<?php

namespace App\Service\Enum;

enum PaymentGatway: string
{
    case MY_FATOORAH = 'myfatoorah';
    case PAYTAB = 'paytab';
    case KASHIER = 'kashier';
    case PAYMOB = 'paymob';
}
