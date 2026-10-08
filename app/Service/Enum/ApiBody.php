<?php

namespace App\Service\Enum;

enum ApiBody: string
{
    case JSON = 'json';
    case XML = 'xml';
    case RAW = 'raw';
    case FORM = 'form';
    case MULTIPART = 'multipart';
    case FILE = 'file';
    case QUERY = 'query';
    case PATH = 'path';
    case HEADER = 'header';
    case COOKIE = 'cookie';
    case BODY = 'body';
    case QUERY_STRING = 'query_string';
    case PATH_STRING = 'path_string';
    case HEADER_STRING = 'header_string';
    case COOKIE_STRING = 'cookie_string';
    case BODY_STRING = 'body_string';
    case QUERY_ARRAY = 'query_array';
    case PATH_ARRAY = 'path_array';
    case HEADER_ARRAY = 'header_array';
    case COOKIE_ARRAY = 'cookie_array';
    case BODY_ARRAY = 'body_array';
    case QUERY_STRING_ARRAY = 'query_string_array';
    case PATH_STRING_ARRAY = 'path_string_array';
    case HEADER_STRING_ARRAY = 'header_string_array';
    case COOKIE_STRING_ARRAY = 'cookie_string_array';
    case BODY_STRING_ARRAY = 'body_string_array';
    case FORM_PARAMS = 'form_params';
}
