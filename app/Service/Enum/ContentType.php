<?php

namespace App\Service\Enum;

enum ContentType: string
{
    case JSON = 'application/json';
    case XML = 'application/xml';
    case FORM_URLENCODED = 'application/x-www-form-urlencoded';
    case FORM_DATA = 'multipart/form-data';
    case PLAIN = 'text/plain';
    case HTML = 'text/html';
    case CSS = 'text/css';
    case CSV = 'text/csv';
    case PDF = 'application/pdf';
    case ZIP = 'application/zip';
    case OCTET_STREAM = 'application/octet-stream';
    case JPEG = 'image/jpeg';
    case PNG = 'image/png';
    case GIF = 'image/gif';
    case WEBP = 'image/webp';
    case SVG = 'image/svg+xml';
    case MP3 = 'audio/mpeg';
    case MP4 = 'video/mp4';
}
