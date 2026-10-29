<?php

namespace App\Service\Enum;

enum ProgramStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
