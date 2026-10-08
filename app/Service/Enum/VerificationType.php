<?php

namespace App\Service\Enum;

enum VerificationType : string
{
    case EMAIL = 'email';
    case PHONE = 'phone';
}
