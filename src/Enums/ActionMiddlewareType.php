<?php

declare(strict_types=1);

namespace ActionMiddleware\Enums;

use ActionMiddleware\Traits\EnumToArray;

enum ActionMiddlewareType: string
{
    use EnumToArray;

    case VALIDATION = 'validation';
    case LISTENER = 'listener';
}
