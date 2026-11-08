<?php

namespace App\Service\Enum;

enum EpisodeStatus: string
{
    case DRAFT = 'draft';
    case IN_PREPARATION = 'in_preparation';
    case UNDER_REVIEW = 'under_review';
    case APPROVED = 'approved';
    case SCHEDULED = 'scheduled';
    case ON_AIR = 'on_air';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case POSTPONED = 'postponed';
}
