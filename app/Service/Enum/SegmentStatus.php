<?php

namespace App\Service\Enum;

enum SegmentStatus : string
{
    case DRAFT = 'draft';
    case IN_PROGRESS = 'in_progress';
    case READY = 'ready';
    case ARCHIVED = 'archived';
}
