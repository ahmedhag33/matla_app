<?php

namespace App\Service\Auth\Enum;

enum Google: string
{
    case URL = 'https://oauth2.googleapis.com';
    case TOKEN_INFO = 'tokeninfo';
    case USER_INFO = 'userinfo';
    case ID_TOKEN = 'id_token';
}
