<?php

namespace App\Service\Enum;

enum TaskEnum : string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
