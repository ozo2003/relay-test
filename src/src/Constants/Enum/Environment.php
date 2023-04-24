<?php declare(strict_types = 1);

namespace App\Constants\Enum;

enum Environment: string
{
    case DEV = 'dev';
    case PROD = 'prod';
    case STAGE = 'stage';
    case TEST = 'test';
}
