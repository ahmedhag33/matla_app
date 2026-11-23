<?php

namespace App\Service\Enum;

enum TaskPriorityEnum : string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}
