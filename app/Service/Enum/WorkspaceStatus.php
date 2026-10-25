<?php

namespace App\Service\Enum;

enum WorkspaceStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case EXPIRED = 'expired';
}
