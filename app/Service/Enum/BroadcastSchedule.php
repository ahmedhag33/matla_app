<?php

namespace App\Service\Enum;

enum BroadcastSchedule: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
}
