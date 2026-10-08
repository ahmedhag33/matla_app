<?php

namespace App\Service\Enum;

enum AuthorizationScheme: string
{
    case BASIC = 'Basic';
    case BEARER = 'Bearer';
    case DIGEST = 'Digest';
    case TOKEN = 'Token';
    case HMAC = 'HMAC';
}
