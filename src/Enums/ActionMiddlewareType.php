<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Enums;

use Uc\ActionMiddleware\Traits\EnumToArray;

enum ActionMiddlewareType: string
{
    use EnumToArray;

    case VALIDATION = 'validation';
    case LISTENER = 'listener';
}
