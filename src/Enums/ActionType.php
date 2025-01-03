<?php

declare(strict_types=1);

namespace ActionMiddleware\Enums;

use ActionMiddleware\Traits\EnumToArray;

enum ActionType: string
{
    use EnumToArray;

    case CREATE_CUSTOMER = 'create_customer';
}
