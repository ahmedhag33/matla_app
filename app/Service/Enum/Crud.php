<?php

namespace App\Service\Enum;

enum Crud: string
{
    case CREATE = 'created';
    case READ = 'read';
    case UPDATE = 'updated';
    case DELETE = 'deleted';
}
