<?php

namespace App\Service\Enum;

enum VerificationActionType: string
{
    case REGISTER = 'register';
    case RESET_PASSWORD = 'reset_password';
    case UPDATE_EMAIL = 'update_email';
    case UPDATE_PHONE = 'update_phone';
    case UPDATE_PASSWORD = 'update_password';
}
