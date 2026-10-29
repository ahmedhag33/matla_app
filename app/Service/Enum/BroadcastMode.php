<?php

namespace App\Service\Enum;

enum BroadcastMode : string
{
    case LIVE = 'live';
    case RECORDED = 'recorded';
}
