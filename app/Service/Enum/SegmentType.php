<?php

namespace App\Service\Enum;

enum SegmentType : string
{
    case OPENING = 'opening';
    case NEWS = 'news';
    case REPORT = 'report';
    case ANALYSIS = 'analysis';
    case INTERVIEW = 'interview';
    case LIVE_CALL = 'live_call';
    case STATISTICS = 'statistics';
    case BREAK = 'break';
    case CLOSING = 'closing';
}
